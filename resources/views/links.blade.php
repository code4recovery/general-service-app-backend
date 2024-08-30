@extends('layouts.app')

@section('title', $entity->name())

@section('description', 'View stories')

@section('content')

    <div class="container max-w-6xl mx-auto px-4 grid gap-8">

        @include('common.alerts')

        @include('common.heading', [
            'title' => $entity->name(),
            'breadcrumbs' => auth()->user()->admin
                ? [
                    route('entities.index', $entity) => __('Entities'),
                ]
                : [],
        ])

        @include('common.nav', [
            'links' => [
                route('entities.stories.index', $entity) => ['newspaper', __('Stories')],
                route('entities.links.index', $entity) => ['chat-bubble-oval-left', __('Links')],
                route('entities.edit', $entity) => ['cog', __('Settings')],
            ],
            'button' => [
                'href' => route('entities.links.create', $entity),
                'label' => __('Create Link'),
                'icon' => 'chat-bubble-oval-left',
            ],
        ])

        @include('common.table', [
            'columns' => [__('Title'), __('Target'), __('Created'), __('Updated')],
            'empty' => __('No links yet.'),
            'reorder' => route('reorder-links', $entity),
            'rows' => $entity->links->map(function ($link) use ($entity) {
                return [
                    'href' => route('entities.links.edit', [$entity, $link]),
                    'id' => $link->id,
                    'values' => [
                        $link->title,
                        $link->target,
                        $link->user->name,
                        $link->updated_at->format('M j, Y'),
                    ],
                ];
            }),
        ])

    </div>

@endsection
