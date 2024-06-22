<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entity;
use App\Models\Story;

class StoryController extends Controller
{
    private $buttons = [0, 1, 2];
    private $types = ['announcement', 'event'];

    private function getStory($storyId)
    {
        $user = auth()->user()->with('entities', 'entities.stories', 'entities.stories.buttons')->first();
        $story = Story::with(['entity', 'buttons'])->where('id', $storyId)->first();

        if (!$story || !$user) {
            return redirect()->route('home');
        }

        if ($user->admin) {
            return $story;
        }

        $story = $entity->stories->where('id', request('story'))->first();

        if (!$story) {
            return redirect()->back()->with('error', 'Story to edit was not found.');
        }

        if ($story->entity->users->where('id', $user->id)->isEmpty()) {
            return redirect()->back()->with('error', 'You do not have permission to edit this story.');
        }

        return $story;
    }

    public function index()
    {
        $user = auth()->user()->with(['entities', 'entities.stories' => function ($query) {
            $query->orderBy('order', 'asc');
        }])->first();

        if ($user->admin) {
            $entity = Entity::with(['stories' => function ($query) {
                $query->orderBy('order', 'asc');
            }])
                ->where('id', request('entity'))
                ->first();
        } else {
            $entity = $user->entities->where('id', request('entity'))->first();
            if (!$entity) {
                return redirect()->route('home');
            }
        }

        return view('stories', ['entity' => $entity]);
    }

    public function create()
    {

        $entity = $this->getEntity(request('entity'));
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
        $entity = $this->getEntity(request('entity'));
        if (!$entity) {
            return redirect()->route('home');
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
            'user_id' => auth()->user()->id,
            'order' => $entity->stories->max('order') + 1,
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
            ->route('entities.stories.index', $entity)
            ->with('success', 'Story created.');
    }

    public function edit()
    {
        $story = $this->getStory(request('story'));

        return view('story', [
            'entity' => $story->entity,
            'story' => $story,
            'buttons' => $this->buttons,
            'types' => $this->types
        ]);
    }

    public function update()
    {
        $story = $this->getStory(request('story'));

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
            ->route('entities.stories.index', $story->entity_id)
            ->with('success', 'Story updated.');
    }

    public function destroy()
    {
        $story = $this->getStory(request('story'));

        foreach ($story->buttons as $button) {
            $button->delete();
        }

        $story->delete();

        $this->updateJson($story->entity_id);

        return redirect()
            ->route('entities.stories.index', $story->entity_id)
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
        $entity = $this->getEntity(request('entity'));
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
