<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entity;

class ButtonController extends Controller
{
    //
    public function create()
    {
        $entity = Entity::find(request('entity'));
        $story = $entity->stories->where('id', request('story'))->first();
        return view('button', ['entity' => $entity, 'story' => $story]);
    }

    public function store()
    {
        $entity = Entity::find(request('entity'));
        $story = $entity->stories->where('id', request('story'))->first();


        $validated = request()->validate([
            'type' => ['required', 'in:link,calendar'],
        ]);

        if ($validated['type'] == 'link') {
            $validated = request()->validate([
                'title' => ['required', 'max:255'],
                'link' => ['required', 'starts_with:http://,https://,mailto:', 'max:255'],
            ]);
            $story->buttons()->create([
                'title' => $validated['title'],
                'type' => 'link',
                'link' => $validated['link'],
                'style' => 'primary',
            ]);
        } else {
            $validated = request()->validate([
                'title' => ['required', 'max:255'],
                'start' => ['required', 'date_format:Y-m-d H:i:s'],
                'end' => ['required', 'date_format:Y-m-d H:i:s'],
                'timezone' => ['required', 'timezone:all'],
                'conference_url' => ['url:https', 'max:255'],
                'formatted_address' => ['max:255'],
            ]);

            $story->buttons()->create([
                'title' => $validated['title'],
                'type' => 'calendar',
                'start' => $validated['start'],
                'end' => $validated['end'],
                'timezone' => $validated['timezone'],
                'conference_url' => $validated['conference_url'],
                'formatted_address' => $validated['formatted_address'],
                'style' => 'primary',
            ]);
        }

        return redirect()
            ->route('entities.stories.edit', ['entity' => $entity, 'story' => $story])
            ->with('success', __('Button created.'));
    }

    public function edit()
    {
        $entity = Entity::find(request('entity'));
        $story = $entity->stories->where('id', request('story'))->first();
        $button = $story->buttons->where('id', request('button'))->first();
        return view('button', compact('entity', 'story', 'button'));
    }

    public function update()
    {
        $entity = Entity::find(request('entity'));
        $story = $entity->stories->where('id', request('story'))->first();
        $button = $story->buttons->where('id', request('button'))->first();

        $validated = request()->validate([
            'type' => ['required', 'in:link,calendar'],
        ]);

        if ($validated['type'] === 'link') {
            dd('mm');
            $validated = request()->validate([
                'title' => ['required', 'max:255'],
                'link' => ['required', 'starts_with:http://,https://,mailto:', 'max:255'],
            ]);
            $button->update([
                'title' => $validated['title'],
                'type' => 'link',
                'link' => $validated['link'],
                'start' => null,
                'end' => null,
                'timezone' => null,
                'conference_url' => null,
                'formatted_address' => null,
                'style' => 'primary',
            ]);
        } else {
            // dd(request('start')); // 2018-06-12T19:30
            $validated = request()->validate([
                'title' => ['required', 'max:255'],
                'start' => ['required', 'date_format:Y-m-d\TH:i'],
                'end' => ['required', 'date_format:Y-m-d\TH:i'],
                'timezone' => ['required', 'timezone:all'],
                'conference_url' => ['max:255'], //'url',
                'formatted_address' => ['max:255'],
            ]);
            $button->update([
                'title' => $validated['title'],
                'type' => 'calendar',
                'start' => $validated['start'],
                'end' => $validated['end'],
                'timezone' => $validated['timezone'],
                'conference_url' => $validated['conference_url'],
                'formatted_address' => $validated['formatted_address'],
                'link' => null,
                'style' => 'primary',
            ]);
        }
        return redirect()
            ->route('entities.stories.edit', ['entity' => $entity, 'story' => $story])
            ->with('success', __('Button updated.'));
    }

    public function destroy()
    {
        $entity = Entity::find(request('entity'));
        $story = $entity->stories->where('id', request('story'))->first();
        $button = $story->buttons->where('id', request('button'))->first();
        $button->delete();
        return redirect()
            ->route('entities.stories.edit', ['entity' => $entity, 'story' => $story])
            ->with('success', __('Button deleted.'));
    }

}
