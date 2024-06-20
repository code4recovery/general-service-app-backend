@extends('layouts.app')

@section('title', $entity->name())

@section('description', 'View stories')

@section('content')

    <div class="container max-w-6xl mx-auto px-4 grid gap-8">

        @include('common.alerts')

        @include('common.heading', [
            'title' => $entity->name(),
            'button' => [
                'href' => route('create-story', $entity->id),
                'label' => 'Create',
            ],
        ])

        @include('common.table', [
            'empty' => 'No stories yet.',
            'headings' => ['Title', 'Type', 'Effective', 'Expires'],
            'reorder' => $entity->stories->count() > 1 ? route('reorder-stories', $entity->id) : null,
            'rows' => $entity->stories->map(function ($story) {
                return [
                    'href' => route('edit-story', [$story->id]),
                    'id' => $story->id,
                    'values' => [
                        $story->title,
                        ucfirst($story->type),
                        $story->start_at->format('M j'),
                        $story->end_at->format('M j'),
                    ],
                ];
            }),
        ])

    </div>

@endsection
