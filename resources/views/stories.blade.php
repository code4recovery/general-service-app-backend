@extends('layouts.app')

@section('title', $entity->name())

@section('description', 'View stories')

@section('content')

    <div class="container max-w-6xl mx-auto px-4 grid gap-8">

        @include('common.alerts')

        @include('common.heading', [
            'title' => $entity->name(),
            'breadcrumbs' => $breadcrumbs,
        ])

        @include('common.nav', [
            'links' => array_merge(
                [
                    route('entities.stories.index', $entity) => ['newspaper', __('Stories')],
                    route('entities.edit', $entity) => ['cog', __('Settings')],
                ],
                isset($entity->area) && !isset($entity->district)
                    ? [
                        route('districts', $entity) => ['home', __('Districts')],
                    ]
                    : []),
            'button' => [
                'href' => route('entities.stories.create', $entity),
                'label' => __('Create Story'),
                'icon' => 'newspaper',
            ],
        ])

        <div class="grid gap-12">
            @foreach ($types as $type => $name)
                <div class="grid gap-3">
                    <h2 class="text-xl font-semibold">{{ __($name) }}</h2>
                    @include('common.table', [
                        'columns' => [__('Title'), __('Effective'), __('Expires')],
                        'empty' => __("No $type yet."),
                        'reorder' => route('reorder-stories', $entity),
                        'rows' => $entity->stories->where('type', $type)->map(function ($story) use ($entity) {
                            return [
                                'href' => route('entities.stories.edit', [$entity, $story]),
                                'id' => $story->id,
                                'values' => [
                                    $story->title,
                                    $story->start_at->format('M j'),
                                    $story->end_at->format('M j'),
                                ],
                            ];
                        }),
                    ])
                </div>
            @endforeach
        </div>

    </div>

@endsection
