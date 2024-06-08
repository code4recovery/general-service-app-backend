<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StoryController extends Controller
{
    //
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

        return view('story', ['district' => $district, 'now' => now()->setTimezone($district->timezone)]);
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
            'buttons' => ['array'],
            'buttons.*.title' => ['max:255'],
            'buttons.*.link' => ['max:255'],
            // 'buttons.*.style' => ['required', 'in:primary,secondary'],
        ]);

        $story = $district->stories()->create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'effective_at' => $validated['effective_at'],
            'expire_at' => $validated['expire_at'],
            'user_id' => $user->id,
            'style' => 'primary',
        ]);

        foreach ($validated['buttons'] as $button) {
            if (empty($button['title']) || empty($button['link'])) {
                continue;
            }
            $story->buttons()->create($button);
        }

        return redirect('/stories/' . $district->area_id . '/' . $district->number);
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

        return view('story', ['district' => $district, 'story' => $story]);
    }
}
