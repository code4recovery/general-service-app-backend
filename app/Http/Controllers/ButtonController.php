<?php

namespace App\Http\Controllers;

use App\Models\Button;
use App\Models\Entity;
use App\Models\Story;

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
                'order' => $story->buttons->max('order') + 1,
            ]);
        } else {
            $validated = request()->validate([
                'title' => ['required', 'max:255'],
                'event_title' => ['required', 'max:255'],
                'start' => ['required', 'date_format:Y-m-d\TH:i'],
                'end' => ['required', 'date_format:Y-m-d\TH:i'],
                'conference_url' => ['nullable', 'max:255', 'url'],
                'formatted_address' => ['max:255'],
                'notes' => [],
            ]);

            $story->buttons()->create([
                'title' => $validated['title'],
                'type' => 'calendar',
                'event_title' => $validated['event_title'],
                'start' => $validated['start'],
                'end' => $validated['end'],
                'timezone' => $entity->timezone,
                'conference_url' => $validated['conference_url'],
                'formatted_address' => $validated['formatted_address'],
                'notes' => $validated['notes'],
                'style' => 'primary',
                'order' => $story->buttons->max('order') + 1,
            ]);
        }

        $this->updateJson($entity->id);

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
            $validated = request()->validate([
                'title' => ['required', 'max:255'],
                'event_title' => ['required', 'max:255'],
                'start' => ['required', 'date_format:Y-m-d\TH:i'],
                'end' => ['required', 'date_format:Y-m-d\TH:i'],
                'conference_url' => ['nullable', 'max:255', 'url'],
                'formatted_address' => ['max:255'],
                'notes' => [],
            ]);

            $button->update([
                'title' => $validated['title'],
                'type' => 'calendar',
                'event_title' => $validated['event_title'],
                'start' => $validated['start'],
                'end' => $validated['end'],
                'timezone' => $entity->timezone,
                'conference_url' => $validated['conference_url'],
                'formatted_address' => $validated['formatted_address'],
                'notes' => $validated['notes'],
                'link' => null,
                'style' => 'primary',
            ]);
        }

        $this->updateJson($entity->id);

        return redirect()
            ->route('entities.stories.buttons.edit', compact('entity', 'story', 'button'))
            ->with('success', __('Button updated.'));
    }

    public function destroy()
    {
        $button = Button::where('id', request('button'))->first();
        $story = $button->story;
        $entity = $story->entity;
        $button->delete();
        return redirect()
            ->route('entities.stories.edit', ['entity' => $entity, 'story' => $story])
            ->with('success', __('Button deleted.'));
    }

    function reorder()
    {
        $story = Story::where('id', request('story'))->first();

        $validated = request()->validate([
            'order' => ['array'],
        ]);

        $buttons = $story->buttons->whereIn('id', $validated['order']);

        foreach ($buttons as $button) {
            $button->update([
                'order' => array_search($button->id, $validated['order']),
            ]);
        }

        print_r($validated['order']);

        self::updateJson($story->entity->id);
    }

}
