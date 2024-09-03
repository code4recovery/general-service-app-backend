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

        if (!$story) {
            return redirect()->back()->with('error', __('Story to edit was not found.'));
        }

        if ($story->entity->users->where('id', $user->id)->isEmpty()) {
            return redirect()->back()->with('error', __('You do not have permission to edit this story.'));
        }

        return $story;
    }

    public function index()
    {
        $user = auth()->user()->with([
            'entities',
            'entities.stories' => function ($query) {
                $query->orderBy('order', 'asc');
            }
        ])->first();

        if ($user->admin) {
            $entity = Entity::with([
                'stories' => function ($query) {
                    $query->orderBy('order', 'asc');
                }
            ])
                ->where('id', request('entity'))
                ->first();
        } else {
            $entity = $user->entities->where('id', request('entity'))->first();
            if (!$entity) {
                return redirect()->route('home');
            }
        }

        $area = $entity->district && $user->admin ? Entity::where('area', $entity->area)->whereNull('district')->first() : null;

        return view('stories', ['entity' => $entity, 'area' => $area]);
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
            'types' => $this->types,
            'language' => $entity->language,
            'languages' => $this->languages,
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
            'description' => ['required'],
            'start_at' => ['required', 'date'],
            'end_at' => ['required', 'date'],
            'type' => ['required', 'in:' . implode(',', $this->types)],
            'language' => ['required', 'in:' . implode(',', array_keys($this->languages))],
        ]);

        $story = $entity->stories()->create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'reference' => $this->reference(),
            'type' => $validated['type'],
            'start_at' => $validated['start_at'],
            'end_at' => $validated['end_at'],
            'language' => $validated['language'],
            'user_id' => auth()->user()->id,
            'order' => $entity->stories->max('order') + 1,
        ]);

        self::updateJson($entity->id);

        return redirect()
            ->route('entities.stories.edit', ['entity' => $entity, 'story' => $story])
            ->with('success', __('Story created.'));
    }

    public function edit()
    {
        $story = $this->getStory(request('story'));

        return view('story', [
            'entity' => $story->entity,
            'story' => $story,
            'buttons' => $this->buttons,
            'types' => $this->types,
            'languages' => $this->languages,
        ]);
    }

    public function update()
    {
        $story = $this->getStory(request('story'));

        $validated = request()->validate([
            'title' => ['required', 'max:255'],
            'description' => ['required'],
            'type' => ['required', 'in:' . implode(',', $this->types)],
            'start_at' => ['required', 'date'],
            'end_at' => ['required', 'date'],
            'language' => ['required', 'in:' . implode(',', array_keys($this->languages))],
        ]);

        $story->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'type' => $validated['type'],
            'language' => $validated['language'],
            'start_at' => $validated['start_at'],
            'end_at' => $validated['end_at'],
        ]);

        self::updateJson($story->entity_id);

        return redirect()
            ->back()
            ->with('success', __('Story updated.'));
    }

    public function destroy()
    {
        $story = $this->getStory(request('story'));

        foreach ($story->buttons as $button) {
            $button->delete();
        }

        $story->delete();

        self::updateJson($story->entity_id);

        return redirect()
            ->route('entities.stories.index', $story->entity_id)
            ->with('success', __('Story deleted.'));
    }

    public function reference()
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

        self::updateJson($entity->id);
    }

}
