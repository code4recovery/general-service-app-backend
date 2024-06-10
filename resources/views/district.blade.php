@extends('layouts.app')

@section('title', $district->name)

@section('description', 'View stories')

@section('content')

    <div class="container max-w-6xl mx-auto px-4 grid gap-8">

        @include('common.alerts')

        @include('common.heading', [
            'title' => 'District ' . $district->number() . ': ' . $district->name,
            'button' => [
                'href' => route('create-story', [$district->area_id, $district->number]),
                'label' => 'Create',
            ],
        ])

        @include('common.table', [
            'rows' => $district->stories->map(function ($story) {
                return [
                    'Title' => $story->title,
                    'Type' => ucfirst($story->type),
                    'Effective' => $story->effective_at->format('M j'),
                    'Expires' => $story->expire_at->format('M j'),
                    'href' => route('edit-story', [$story->id]),
                ];
            }),
            'empty' => 'No stories yet.',
        ])
    </div>

@endsection
