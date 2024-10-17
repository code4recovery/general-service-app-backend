@extends('layouts.app')

@section('title', 'Districts')

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
        ])

        @include('common.table', [
            'columns' => [__('Name'), __('Type'), __('Users'), __('Stories')],
            'empty' => __('No districts yet.'),
            'rows' => $districts->map(function ($entity) {
                return [
                    'href' => route('entities.stories.index', $entity),
                    'values' => [
                        $entity->name(),
                        $entity->type(),
                        $entity->users->count() ? $entity->users->count() : '',
                        $entity->stories->count() ? $entity->stories->count() : '',
                    ],
                ];
            }),
        ])

    </div>

@endsection
