<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;
use App\Models\District;

class EntityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $areas = Area::with('districts')->orderBy('id')->get();
        return view('entities', ['areas' => $areas]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $user = auth()->user()->with('districts', 'districts.stories', 'districts.area')->first();

        if ($user->admin) {
            $district = District::with('stories', 'area')
                ->where('area_id', request('areaId'))
                ->where('number', request('districtNumber'))
                ->first();
        } else {
            $district = $user->districts->where(function ($district) {
                return $district->area_id == request('areaId') && $district->number == request('districtNumber');
            })->first();
            if (!$district) {
                return redirect()->route('home');
            }
        }

        return view('entity', ['district' => $district]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
