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
            'empty' => 'No links yet.',
            'headings' => [__('Title'), __('Target'), __('Created'), __('Updated')],
            'reorder' => $entity->links->count() > 1 ? route('reorder-links', $entity) : null,
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
