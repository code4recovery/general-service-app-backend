@extends('layouts.app')

@section('title', $entity->name())

@section('description', 'View stories')

@section('content')

    <div class="container max-w-6xl mx-auto px-4 grid gap-8">

        @include('common.alerts')

        @include('common.heading', [
            'title' => $entity->name(),
        ])

        @include('common.nav', [
            'links' => [
                route('entities.stories.index', $entity) => ['newspaper', 'Stories'],
                route('entities.links.index', $entity) => ['chat-bubble-oval-left', 'Links'],
                route('entities.edit', $entity) => ['cog', 'Settings'],
            ],
            'button' => [
                'href' => route('entities.stories.create', $entity),
                'label' => 'Create Story',
                'icon' => 'newspaper',
            ],
        ])

        @include('common.table', [
            'empty' => 'No stories yet.',
            'headings' => ['Title', 'Type', 'Effective', 'Expires'],
            'reorder' => $entity->stories->count() > 1 ? route('reorder-stories', $entity) : null,
            'rows' => $entity->stories->map(function ($story) use ($entity) {
                return [
                    'href' => route('entities.stories.edit', [$entity, $story]),
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
