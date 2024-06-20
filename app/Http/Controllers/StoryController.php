<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Story;

class StoryController extends Controller
{
    private $buttons = [0, 1, 2];
    private $types = ['announcement', 'event'];

    public function create()
    {
        $user = auth()->user()->with('entities')->first();
        $entity = $user->entities->where('id', request('entityId'))->first();

        if (!$entity) {
            return redirect()->route('home');
        }

        return view('story', [
            'entity' => $entity,
            'now' => now()->setTimezone('America/Chicago'),
            'buttons' => $this->buttons,
            'types' => $this->types
        ]);
    }

    public function store()
    {
        $user = auth()->user()->with('entities')->first();
        $entity = $user->entities->where('id', request('entityId'))->first();

        if (!$entity) {
            return redirect('/');
        }

        $validated = request()->validate([
            'title' => ['required', 'max:255'],
            'description' => ['required', 'max:255'],
            'start_at' => ['required', 'date'],
            'end_at' => ['required', 'date'],
            'type' => ['required', 'in:' . implode(',', $this->types)],
            'buttons' => ['array'],
            'buttons.*.title' => ['max:255'],
            'buttons.*.link' => ['max:255'],
        ]);

        $story = $entity->stories()->create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'reference' => $this->reference(),
            'type' => $validated['type'],
            'start_at' => $validated['start_at'],
            'end_at' => $validated['end_at'],
            'language' => 'en',
            'user_id' => $user->id,
            'order' => $entity->stories->count(),
        ]);

        foreach ($validated['buttons'] as $button) {
            if (empty($button['title']) || empty($button['link'])) {
                continue;
            }
            $story->buttons()->create([
                'title' => $button['title'],
                'link' => $button['link'],
                'style' => 'primary',
            ]);
        }

        $this->updateJson($entity->id);

        return redirect()
            ->route('entity', $entity->id)
            ->with('success', 'Story created.');
    }

    public function edit()
    {
        $user = auth()->user()->with('entities', 'entities.stories', 'entities.stories.buttons')->first();
        $story = Story::where('id', request('story'))->first();
        $entity = $user->entities->where('id', $story->entity_id)->first();

        if (!$entity) {
            return redirect()->route('home');
        }

        $story = $entity->stories->where('id', request('story'))->first();

        if (!$story) {
            return redirect()->route('home');
        }

        return view('story', [
            'entity' => $entity,
            'story' => $story,
            'buttons' => $this->buttons,
            'types' => $this->types
        ]);
    }

    public function update()
    {
        $user = auth()->user()->with('entities')->first();

        $story = Story::with('buttons', 'entity', 'entity.users')->where('id', request('story'))->first();

        if (!$story) {
            return redirect()->back()->with('error', 'Story to edit was not found.');
        }

        if ($story->entity->users->where('id', $user->id)->isEmpty()) {
            return redirect()->back()->with('error', 'You do not have permission to edit this story.');
        }

        $validated = request()->validate([
            'title' => ['required', 'max:255'],
            'description' => ['required', 'max:255'],
            'type' => ['required', 'in:' . implode(',', $this->types)],
            'start_at' => ['required', 'date'],
            'end_at' => ['required', 'date'],
            'buttons' => ['array'],
            'buttons.*.id' => ['max:255'],
            'buttons.*.title' => ['max:255'],
            'buttons.*.link' => ['max:255'],
        ]);

        $story->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'type' => $validated['type'],
            'start_at' => $validated['start_at'],
            'end_at' => $validated['end_at'],
        ]);

        foreach ($this->buttons as $index) {
            if (empty($validated['buttons'][$index]['title']) || empty($validated['buttons'][$index]['link'])) {
                if (!empty($validated['buttons'][$index]['id'])) {
                    $story->buttons()->where('id', $validated['buttons'][$index]['id'])->delete();
                }
            } else {
                if (empty($validated['buttons'][$index]['id'])) {
                    $story->buttons()->create([
                        'title' => $validated['buttons'][$index]['title'],
                        'link' => $validated['buttons'][$index]['link'],
                        'style' => 'primary',
                    ]);
                } else {
                    $story->buttons()->where('id', $validated['buttons'][$index]['id'])->update([
                        'title' => $validated['buttons'][$index]['title'],
                        'link' => $validated['buttons'][$index]['link'],
                    ]);
                }
            }
        }

        $this->updateJson($story->entity_id);

        return redirect()
            ->route('entity', $story->entity_id)
            ->with('success', 'Story updated.');
    }

    public function destroy()
    {
        $user = auth()->user()->with('entities')->first();

        $story = Story::with('entity', 'entity.users', 'buttons')->where('id', request('story'))->first();

        if (!$story) {
            return redirect()->back()->with('error', 'Story to delete was not found.');
        }

        if ($story->entity->users->where('id', $user->id)->isEmpty()) {
            return redirect()->back()->with('error', 'You do not have permission to delete this story.');
        }

        foreach ($story->buttons as $button) {
            $button->delete();
        }

        $story->delete();

        $this->updateJson($story->entity_id);

        return redirect()
            ->route('entity', $story->entity_id)
            ->with('success', 'Story deleted.');
    }

    private function reference()
    {
        $reference = substr(bin2hex(random_bytes(7)), 0, 7);
        if (Story::where('reference', $reference)->exists()) {
            return $this->reference();
        }
        return $reference;
    }

    public function reorder()
    {
        $user = auth()->user()->with('entities')->first();

        $entity = $user->entities->where('id', request('entityId'))->first();

        if (!$entity) {
            return redirect()->route('home');
        }

        $validated = request()->validate([
            'order' => ['array'],
        ]);

        $stories = $entity->stories->whereIn('id', $validated['order']);

        foreach ($stories as $story) {
            $story->update([
                'order' => array_search($story->id, $validated['order']),
            ]);
        }

        $this->updateJson($entity->id);
    }

}
