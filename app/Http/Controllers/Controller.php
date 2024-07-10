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

    public function select()
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

    public function relations()
    {
        return [
            'stories' => function ($query) {
                $query->select('id', 'entity_id', 'title', 'description', 'type', 'reference', 'language', 'start_at', 'end_at')->orderBy('order');
            },
            'stories.buttons' => function ($query) {
                $query->select('id', 'story_id', 'title', 'link');
            },
            'links' => function ($query) {
                $query->select('id', 'entity_id', 'title', 'target', 'language')->orderBy('order');
            },
        ];
    }

    public function deleteJson($areaId, $districtId)
    {
        $filename = $areaId . '-' . $districtId . '.json';
        if (Storage::disk('public')->exists($filename)) {
            Storage::disk('public')->delete($filename);
        }
    }

    public function updateJson($entity_id)
    {
        $entity = Entity::where('id', $entity_id)->with($this->relations())->select($this->select())->first();

        if ($entity->district) {
            $area = Entity::with($this->relations())->select($this->select())->where('area', $entity->area)->whereNull('district')->first();
            $gso = Entity::with($this->relations())->select($this->select())->whereNull('area')->whereNull('district')->first();
            $this->updateDistrictJson($entity, $area, $gso);
        } elseif ($entity->area) {
            $gso = Entity::with($this->relations())->select($this->select())->whereNull('area')->whereNull('district')->first();
            $this->updateAreaJson($entity, $gso);
        } else {
            $this->updateGsoJson($entity);
        }
    }

    public function updateDistrictJson($district, $area, $gso)
    {
        $filename = $district->area . '-' . $district->district . '.json';
        $content = collect([$district, $area, $gso])->toJson(env('APP_DEBUG', false) ? JSON_PRETTY_PRINT : 0);
        Storage::disk('public')->put($filename, $content);
    }

    public function updateAreaJson($area, $gso)
    {
        Entity::with($this->relations())->select($this->select())->where('area', $area->area)->whereNotNull('district')->get()->each(function ($district) use ($area, $gso) {
            $this->updateDistrictJson($district, $area, $gso);
        });
    }

    public function updateGsoJson($gso)
    {
        Entity::with($this->relations())->select($this->select())->whereNotNull('area')->whereNull('district')->get()->each(function ($area) use ($gso) {
            $this->updateAreaJson($area, $gso);
        });
    }

    public static function updateMapJson()
    {
        $districts = Entity::whereNotNull('boundary')->select(DB::raw('(ST_AsGeoJSON(boundary)) AS `boundary`, name, area, website, language, color'))->get();
        $areas = Entity::whereNotNull('area')->whereNull('district')->get()->map(function ($area) use ($districts) {
            return [
                'area' => $area->area,
                'name' => $area->name,
                'website' => $area->website,
                'districts' => $districts->where('area', $area->area)->map(function ($district) {
                    return [
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
