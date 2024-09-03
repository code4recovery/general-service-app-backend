@extends('layouts.app')

@section('title', $entity->name())

@section('description', 'View stories')

@section('content')

    <div class="container max-w-6xl mx-auto px-4 grid gap-8">

        @include('common.alerts')

        @include('common.heading', [
            'title' => $entity->name(),
            'breadcrumbs' => array_filter(
                array_merge(auth()->user()->admin
                        ? [
                            route('entities.index') => __('Entities'),
                        ]
                        : [],
                    isset($area)
                        ? [
                            route('entities.edit', $area->id) => $area->name(),
                        ]
                        : [])),
        ])

        @include('common.nav', [
            'links' => [
                route('entities.stories.index', $entity) => ['newspaper', __('Stories')],
                route('entities.links.index', $entity) => ['chat-bubble-oval-left', __('Links')],
                route('entities.edit', $entity) => ['cog', __('Settings')],
            ],
            'button' => [
                'href' => route('entities.stories.create', $entity),
                'label' => __('Create Story'),
                'icon' => 'newspaper',
            ],
        ])

        @include('common.table', [
            'columns' => [__('Title'), __('Type'), __('Effective'), __('Expires')],
            'empty' => __('No stories yet.'),
            'reorder' => route('reorder-stories', $entity),
            'rows' => $entity->stories->map(function ($story) use ($entity) {
                return [
                    'href' => route('entities.stories.edit', [$entity, $story]),
                    'id' => $story->id,
                    'values' => [
                        $story->title,
                        __(ucfirst($story->type)),
                        $story->start_at->format('M j'),
                        $story->end_at->format('M j'),
                    ],
                ];
            }),
        ])

    </div>

@endsection
