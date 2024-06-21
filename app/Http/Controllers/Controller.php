<?php

namespace App\Http\Controllers;

use App\Models\Entity;
use Illuminate\Support\Facades\Storage;

abstract class Controller
{
    public function select()
    {
        return [
            'id',
            'area',
            'district',
            'name',
            'banner',
            'website',
            'language'
        ];
    }

    public function relations()
    {
        return [
            'stories' => function ($query) {
                $query->select('id', 'entity_id', 'title', 'description', 'type', 'reference', 'language', 'start_at', 'end_at')->orderBy('order');
            },
            'stories.buttons' => function ($query) {
                $query->select('id', 'story_id', 'title', 'link');
            }
        ];
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
}
