@extends('layouts.app')

@section('title', 'Districts')

@section('content')

    <div class="max-w-6xl mx-auto px-4 grid gap-8">

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

        <div class="divide-y divide-gray-300 dark:divide-gray-600">
            @foreach ($districts as $district)
                <livewire:entity-row :entity="$district" :active="true" />
            @endforeach
        </div>

    </div>

@endsection
