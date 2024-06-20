@extends('layouts.app')

@section('title', 'Entities')

@section('description', 'View all service entities.')

@section('content')

    <div class="container max-w-6xl mx-auto px-4 grid gap-8">

        @include('common.alerts')

        @include('common.heading', [
            'title' => 'Entites',
        ])

        @include('common.table', [
            'empty' => 'No entities yet.',
            'headings' => ['Name', 'Type', 'Users', 'Stories'],
            'rows' => $entities->map(function ($entity) {
                return [
                    'href' => route('entity', $entity->id),
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
