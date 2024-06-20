<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entity;

class EntityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $entities = Entity::with(['stories', 'users'])->orderBy('area')->orderBy('district')->get();
        return view('entities', ['entities' => $entities]);
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
        $user = auth()->user()->with(['entities', 'entities.stories' => function ($query) {
            $query->orderBy('order', 'asc');
        }])->first();

        if ($user->admin) {
            $entity = Entity::with(['stories' => function ($query) {
                $query->orderBy('order', 'asc');
            }])
                ->where('id', request('entityId'))
                ->first();
        } else {
            $entity = $user->entities->where('id', request('entityId'))->first();
            if (!$entity) {
                return redirect()->route('home');
            }
        }

        return view('entity', ['entity' => $entity]);
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
