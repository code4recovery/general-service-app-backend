<?php

namespace App\Http\Controllers;

use App\Models\Entity;
use Illuminate\Support\Facades\Storage;

abstract class Controller
{
    public function updateJson($entity_id)
    {
        $entity = Entity::where('id', $entity_id)->with('stories', 'stories.buttons')->first();

        if ($entity->district) {
            $this->updateDistrictJson($entity);
        } elseif ($entity->area) {
            $this->updateAreaJson($entity);
        } else {
            $this->updateGsoJson($entity);
        }
    }

    public function formatNumber($number)
    {
        return str_pad($number, 2, '0', STR_PAD_LEFT);
    }

    public function updateDistrictJson($district)
    {
        $filename = 'area-' . $this->formatNumber($district->area) . '-district-' . $this->formatNumber($district->district) . '.json';
        Storage::disk('public')->put($filename, $district->toJson(env('APP_DEBUG', false) ? JSON_PRETTY_PRINT : 0));
    }

    public function updateAreaJson($area)
    {
    }

    public function updateGsoJson($gso)
    {
    }
}
