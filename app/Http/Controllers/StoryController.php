<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Story;

class StoryController extends Controller
{
    private $buttons = [0, 1, 2];
    private $types = ['announcement', 'event'];

    public function index()
    {
        $user = auth()->user()->with('districts', 'districts.stories', 'districts.area')->first();
        $district = $user->districts->where(function ($district) {
            return $district->area_id == request('areaId') && $district->number == request('districtNumber');
        })->first();

        if (!$district) {
            return redirect()->route('home');
        }

        return view('district', ['district' => $district]);
    }

    public function create()
    {
        $user = auth()->user()->with('districts', 'districts.area')->first();
        $district = $user->districts->where(function ($district) {
            return $district->area_id == request('areaId') && $district->number == request('districtNumber');
        })->first();

        if (!$district) {
            return redirect()->route('home');
        }

        return view('story', [
            'district' => $district,
            'now' => now()->setTimezone($district->timezone),
            'buttons' => $this->buttons,
            'types' => $this->types
        ]);
    }

    public function store()
    {
        $user = auth()->user()->with('districts', 'districts.area')->first();
        $district = $user->districts->where(function ($district) {
            return $district->area_id == request('areaId') && $district->number == request('districtNumber');
        })->first();

        if (!$district) {
            return redirect('/');
        }

        $validated = request()->validate([
            'title' => ['required', 'max:255'],
            'description' => ['required', 'max:255'],
            'effective_at' => ['required', 'date'],
            'expire_at' => ['required', 'date'],
            'type' => ['required', 'in:' . implode(',', $this->types)],
            'buttons' => ['array'],
            'buttons.*.title' => ['max:255'],
            'buttons.*.link' => ['max:255'],
        ]);

        $story = $district->stories()->create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'type' => $validated['type'],
            'effective_at' => $validated['effective_at'],
            'expire_at' => $validated['expire_at'],
            'user_id' => $user->id,
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

        $this->updateDistrictJson($district->id);

        return redirect()
            ->route('district', [$district->area_id, $district->number])
            ->with('success', 'Story created.');
    }

    public function edit()
    {
        $user = auth()->user()->with('districts', 'districts.stories', 'districts.stories.buttons', 'districts.area')->first();
        $district = $user->districts->first();

        if (!$district) {
            return redirect()->route('home');
        }

        $story = $district->stories->where('id', request('story'))->first();

        if (!$story) {
            return redirect()->route('home');
        }

        return view('story', [
            'district' => $district,
            'story' => $story,
            'buttons' => $this->buttons,
            'types' => $this->types
        ]);
    }

    public function update()
    {
        $user = auth()->user()->with('districts')->first();

        $story = Story::with('buttons', 'district', 'district.users')->where('id', request('story'))->first();

        if (!$story) {
            return redirect()->back()->with('error', 'Story to edit was not found.');
        }

        if ($story->district->users->where('id', $user->id)->isEmpty()) {
            return redirect()->back()->with('error', 'You do not have permission to edit this story.');
        }

        $validated = request()->validate([
            'title' => ['required', 'max:255'],
            'description' => ['required', 'max:255'],
            'type' => ['required', 'in:' . implode(',', $this->types)],
            'effective_at' => ['required', 'date'],
            'expire_at' => ['required', 'date'],
            'buttons' => ['array'],
            'buttons.*.id' => ['max:255'],
            'buttons.*.title' => ['max:255'],
            'buttons.*.link' => ['max:255'],
        ]);

        $story->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'type' => $validated['type'],
            'effective_at' => $validated['effective_at'],
            'expire_at' => $validated['expire_at'],
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

        $this->updateDistrictJson($story->district->id);

        return redirect()
            ->route('district', [$story->district->area_id, $story->district->number])
            ->with('success', 'Story updated.');
    }

    public function destroy()
    {
        $user = auth()->user()->with('districts')->first();

        $story = Story::with('district', 'district.users', 'buttons')->where('id', request('story'))->first();

        if (!$story) {
            return redirect()->back()->with('error', 'Story to delete was not found.');
        }

        if ($story->district->users->where('id', $user->id)->isEmpty()) {
            return redirect()->back()->with('error', 'You do not have permission to delete this story.');
        }

        foreach ($story->buttons as $button) {
            $button->delete();
        }

        $story->delete();

        $this->updateDistrictJson($story->district->id);

        return redirect()
            ->route('district', [$story->district->area_id, $story->district->number])
            ->with('success', 'Story deleted.');
    }
}
