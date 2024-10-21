<?php

namespace App\Http\Controllers;


use App\Models\Entity;
use App\Models\User;
use Intervention\Image\Laravel\Facades\Image;

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

        if (!$entity) {
            return redirect()->route('home');
        }

        return view('entity', [
            'entity' => $entity,
            'languages' => $this->languages,
            'districts' => $districts,
            'breadcrumbs' => self::breadcrumbs($entity)
        ]);
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
            'map_id' => ['nullable', 'max:255'],
            'timezone' => ['required', 'timezone:all'],
        ]);

        $updates = [
            'name' => $validated['name'],
            'area' => $validated['area'],
            'district' => $validated['district'],
            'website' => $validated['website'],
            'language' => $validated['language'],
            'map_id' => !empty($validated['map_id']) ? $validated['map_id'] : null,
            'timezone' => $validated['timezone'],
        ];

        foreach (['banner', 'banner_dark'] as $banner) {
            if (request()->hasFile($banner)) {
                $file = request()->file($banner);
                $path = $banner . '/' . $entity->id . '.' . $file->getClientOriginalExtension();
                Image::read($file->getRealPath())->scaleDown(width: 1200)->save(storage_path('app/public/' . $path));
                $updates[$banner] = url($path);
            }
        }

        $entity->update($updates);

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

    public function districts()
    {
        $entity = Entity::where('id', request('entity'))->first();
        $districts = Entity::where('area', $entity->area)->whereNotNull('district')->orderBy('district')->get();
        $breadcrumbs = self::breadcrumbs($entity);
        return view('districts', compact('entity', 'breadcrumbs', 'districts'));
    }


}
