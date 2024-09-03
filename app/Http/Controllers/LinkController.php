<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entity;
use App\Models\Link;

class LinkController extends Controller
{
    public function index()
    {
        $user = auth()->user()->with([
            'entities',
            'entities.links' => function ($query) {
                $query->orderBy('order', 'asc');
            }
        ])->first();

        if ($user->admin) {
            $entity = Entity::with([
                'links' => function ($query) {
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

        return view('links', ['entity' => $entity, 'area' => $area]);
    }

    public function create()
    {

        $entity = $this->getEntity(request('entity'));
        if (!$entity) {
            return redirect()->route('home');
        }
        return view('link', [
            'entity' => $entity,
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
            'target' => ['required', 'max:255'],
        ]);

        $story = $entity->links()->create([
            'title' => $validated['title'],
            'target' => $validated['target'],
            'language' => 'en',
            'user_id' => auth()->user()->id,
            'order' => $entity->links->max('order') + 1,
        ]);

        self::updateJson($entity->id);

        return redirect()
            ->route('entities.links.index', $entity)
            ->with('success', __('Link created.'));
    }

    public function edit(string $id)
    {
        $link = $this->getLink(request('link'));

        return view('link', [
            'entity' => $link->entity,
            'link' => $link,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $link = $this->getLink(request('link'));

        $validated = request()->validate([
            'title' => ['required', 'max:255'],
            'target' => ['required', 'max:255'],
        ]);

        $link->update([
            'title' => $validated['title'],
            'target' => $validated['target'],
        ]);

        self::updateJson($link->entity_id);

        return redirect()
            ->route('entities.links.index', $link->entity_id)
            ->with('success', __('Link updated.'));
    }

    public function destroy()
    {
        $link = $this->getLink(request('link'));

        $link->delete();

        self::updateJson($link->entity_id);

        return redirect()
            ->route('entities.links.index', $link->entity_id)
            ->with('success', __('Link deleted.'));
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

        $links = $entity->links->whereIn('id', $validated['order']);

        foreach ($links as $link) {
            $link->update([
                'order' => array_search($link->id, $validated['order']),
            ]);
        }

        self::updateJson($entity->id);
    }

    public function getLink($linkId)
    {
        $user = auth()->user()->with('entities', 'entities.links')->first();
        $link = Link::with(['entity'])->where('id', $linkId)->first();

        if (!$link || !$user) {
            return redirect()->route('home');
        }

        if ($user->admin) {
            return $link;
        }

        if (!$link) {
            return redirect()->back()->with('error', __('Link to edit was not found.'));
        }

        if ($link->entity->users->where('id', $user->id)->isEmpty()) {
            return redirect()->back()->with('error', __('You do not have permission to edit this link.'));
        }

        return $link;
    }

}
