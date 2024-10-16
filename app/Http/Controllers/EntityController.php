<?php

namespace App\Http\Controllers;


use App\Models\Entity;
use App\Models\User;

class EntityController extends Controller
{
    public function index()
    {
        $admins = User::where('admin', true)->get();

        $districts = Entity::whereNotNull('district')->get();

        $areas = Entity::whereNull('district')->with(['users'])->get()->map(function ($area) use ($districts) {
            $area->districts = $districts->where('area', $area->area)->count();
            return $area;
        });

        return view('entities', compact('admins', 'areas'));
    }

    public function edit()
    {
        $entity = $this->getEntity(request('entity'));

        $admin = auth()->user()->admin;

        $districts = !$entity->district && $admin ? Entity::with(['stories', 'users'])
            ->where('area', $entity->area)
            ->whereNotNull('district')
            ->orderBy('district')
            ->get() : [];

        $area = $entity->district && $admin ? Entity::where('area', $entity->area)->whereNull('district')->first() : null;

        if (!$entity) {
            return redirect()->route('home');
        }

        return view('entity', ['entity' => $entity, 'languages' => $this->languages, 'districts' => $districts, 'area' => $area]);
    }

    public function update()
    {
        $entity = $this->getEntity(request('entity'));
        if (!$entity) {
            return redirect()->route('home');
        }

        $validated = request()->validate([
            'name' => ['max:255'],
            'area' => ['nullable', 'integer'],
            'district' => ['max:255'],
            'website' => ['max:255'],
            'language' => ['max:2'],
            'banner' => ['max:255'],
            'banner_dark' => ['max:255'],
            'map_id' => ['nullable', 'max:255'],
            'timezone' => ['required', 'timezone:all'],
        ]);

        $entity->update([
            'name' => $validated['name'],
            'area' => $validated['area'],
            'district' => $validated['district'],
            'website' => $validated['website'],
            'language' => $validated['language'],
            'banner' => $validated['banner'],
            'banner_dark' => $validated['banner_dark'],
            'map_id' => !empty($validated['map_id']) ? $validated['map_id'] : null,
            'timezone' => $validated['timezone'],
        ]);

        self::updateJson($entity->id);

        self::updateMapJson();

        return redirect()
            ->back()
            ->with('success', __('Entity updated.'));

    }

    public function destroy()
    {
        $entity = $this->getEntity(request('entity'));

        if (!$entity) {
            return redirect()->route('entities.index');
        }

        $entity->delete();

        $this->deleteJson($entity->area, $entity->district);

        return redirect()
            ->route('entities.index', $entity->id)
            ->with('success', __('Entity deleted.'));

    }
}
