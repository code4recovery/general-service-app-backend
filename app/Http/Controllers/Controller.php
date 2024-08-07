<?php

namespace App\Http\Controllers;

use App\Models\Entity;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

abstract class Controller
{
    public function getEntity($entityId)
    {
        $user = auth()->user()->with('entities')->first();

        return ($user->admin)
            ? Entity::where('id', $entityId)->first()
            : $user->entities->where('id', $entityId)->first();
    }

    public static function select()
    {
        return [
            'id',
            'area',
            'district',
            'name',
            'banner',
            'banner_dark',
            'website',
            'language'
        ];
    }

    public $languages = [
        'en' => 'English',
        'es' => 'Español',
        'fr' => 'Français',
    ];

    public static function relations()
    {
        return [
            'stories' => function ($query) {
                $query->select('id', 'entity_id', 'title', 'description', 'type', 'reference', 'language', 'start_at', 'end_at')
                    ->where('end_at', '>=', now())
                    ->orderBy('order')
                    ->orderBy('created_at', 'desc');
            },
            'stories.buttons' => function ($query) {
                $query->select('id', 'story_id', 'title', 'link');
            },
            'links' => function ($query) {
                $query->select('id', 'entity_id', 'title', 'target', 'language')->orderBy('order');
            },
        ];
    }

    public static function deleteJson($areaId, $districtId)
    {
        $filename = $areaId . '-' . $districtId . '.json';
        if (Storage::disk('public')->exists($filename)) {
            Storage::disk('public')->delete($filename);
        }
    }

    public static function updateJson($entity_id)
    {
        $entity = Entity::where('id', $entity_id)->with(self::relations())->select(self::select())->first();

        if ($entity->district) {
            $area = Entity::with(self::relations())->select(self::select())->where('area', $entity->area)->whereNull('district')->first();
            $gso = Entity::with(self::relations())->select(self::select())->whereNull('area')->whereNull('district')->first();
            self::updateDistrictJson($entity, $area, $gso);
        } elseif ($entity->area) {
            $gso = Entity::with(self::relations())->select(self::select())->whereNull('area')->whereNull('district')->first();
            self::updateAreaJson($entity, $gso);
        } else {
            self::updateGsoJson($entity);
        }
    }

    public static function updateDistrictJson($district, $area, $gso)
    {
        $filename = $district->id . '.json';

        $entities = [$district->toArray(), $area->toArray(), $gso->toArray()];

        $content = array_map(function ($entity) use ($district) {
            $entity['stories'] = array_values(array_filter($entity['stories'], function ($story) use ($district) {
                return $story['language'] === $district->language;
            }));
            return $entity;
        }, $entities);

        $json = json_encode($content, env('APP_DEBUG', false) ? JSON_PRETTY_PRINT : 0);

        Storage::disk('public')->put($filename, $json);
    }

    public static function updateAreaJson($area, $gso)
    {
        Entity::with(self::relations())->select(self::select())->where('area', $area->area)->whereNotNull('district')->get()->each(function ($district) use ($area, $gso) {
            self::updateDistrictJson($district, $area, $gso);
        });
    }

    public static function updateGsoJson($gso)
    {
        Entity::with(self::relations())->select(self::select())->whereNotNull('area')->whereNull('district')->get()->each(function ($area) use ($gso) {
            self::updateAreaJson($area, $gso);
        });
    }

    public static function updateMapJson()
    {
        $districts = Entity::whereNotNull('boundary')->select(DB::raw('(ST_AsGeoJSON(boundary)) AS `boundary`, id, name, area, district, website, language, color'))->get();
        $areas = Entity::whereNotNull('area')->whereNull('district')->get()->map(function ($area) use ($districts) {
            return [
                'area' => $area->area,
                'name' => $area->name,
                'website' => $area->website,
                'districts' => $districts->where('area', $area->area)->map(function ($district) {
                    return [
                        'id' => $district->id,
                        'district' => $district->district,
                        'name' => $district->name,
                        'website' => $district->website,
                        'language' => $district->language,
                        'color' => $district->color,
                        'boundary' => json_decode($district->boundary)->coordinates[0],
                    ];
                })->values()->toArray()
            ];
        })->filter(function ($area) {
            return count($area['districts']) > 0;
        })->values();
        Storage::put('public/map.json', $areas->toJson(env('APP_DEBUG', false) ? JSON_PRETTY_PRINT : 0));
    }
}
