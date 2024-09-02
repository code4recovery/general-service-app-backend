<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entity;

class EntityController extends Controller
{
    public function index()
    {
        $entities = Entity::with(['stories', 'users'])->whereNull('district')->orderBy('area')->orderBy('district')->get();
        return view('entities', ['entities' => $entities]);
    }

    /*
    public function create()
    {
        return view('entity', ['languages' => $this->languages]);
    }

    public function store(Request $request)
    {
        $validated = request()->validate([
            'name' => ['required', 'max:255'],
            'area' => ['integer'],
            'district' => ['max:5'],
            'website' => ['max:255'],
            'language' => ['max:2'],
            'banner' => ['max:255'],
            'banner_dark' => ['max:255'],
        ]);

        $entity = Entity::create([
            'name' => $validated['name'],
            'area' => $validated['area'],
            'district' => $validated['district'],
            'website' => $validated['website'],
            'language' => $validated['language'],
            'banner' => $validated['banner'],
            'banner_dark' => $validated['banner_dark'],
        ]);

        self::updateJson($entity->id);

        return redirect()
            ->route('entities.index')
            ->with('success', __('Entity created.'));
    }
    */

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
