@extends('layouts.app')

@section('title', 'Areas')

@section('description', 'View stories')

@section('content')

    <div class="container max-w-6xl mx-auto px-4 grid gap-8">

        @include('common.alerts')

        @include('common.heading', [
            'title' => 'Areas',
        ])

        @include('common.table', [
            'rows' => $areas->map(function ($area) {
                return [
                    'Title' => $area->name,
                    'Number' => $area->number(),
                    'Districts' => $area->districts->count() ?: '',
                    '???' => '??',
                    'href' => route('area', [$area->id]),
                ];
            }),
            'empty' => 'No areas yet.',
        ])
    </div>

@endsection
