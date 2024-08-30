@extends('layouts.app')

@section('title', 'Entities')

@section('description', 'View all service entities.')

@section('content')

    <div class="container max-w-6xl mx-auto px-4 grid gap-8">

        @include('common.alerts')

        @include('common.heading', [
            'title' => __('Entities'),
        ])

        @include('common.table', [
            'columns' => [__('Name'), __('Type'), __('Users'), __('Stories')],
            'empty' => __('No entities yet.'),
            'rows' => $entities->map(function ($entity) {
                return [
                    'href' => route('entities.edit', $entity),
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
