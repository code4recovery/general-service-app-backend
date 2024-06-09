<?php

namespace App\Http\Controllers;

use App\Models\District;
use Illuminate\Support\Facades\Storage;

abstract class Controller
{
    public function updateDistrictJson($district_id)
    {
        $district = District::select(['id', 'name', 'area_id', 'number'])->with([
            'area' => function ($query) {
                $query->select(['id', 'name', 'website']);
            },
            'stories' => function ($query) {
                $query->select(['id', 'title', 'description', 'district_id', 'effective_at', 'expire_at', 'type']);
            },
            'stories.buttons' => function ($query) {
                $query->select(['id', 'story_id', 'title', 'link', 'style']);
            }
        ])->where('id', $district_id)->first();
        $json = json_encode($district->toArray(), env('APP_DEBUG', false) ? JSON_PRETTY_PRINT : 0);
        $filename = implode('-', ['area', $district->area->number(), 'district', $district->number()]) . '.json';
        Storage::disk('public')->put($filename, $json);
    }
}
