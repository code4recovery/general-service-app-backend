@extends('layouts.app')

@section('title', isset($link) ? 'Edit Link' : 'Create Link')

@section('description', 'Create or edit a link.')

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
        ])

        <form method="post" class="grid gap-8"
            action="{{ isset($link) ? route('entities.links.update', [$entity, $link]) : route('entities.links.store', $entity) }}">
            @csrf
            @isset($link)
                @method('put')
            @endisset

            <div class="grid lg:grid-cols-2 gap-3 lg:gap-8">
                @include('common.input', [
                    'label' => 'Title',
                    'name' => 'title',
                    'type' => 'text',
                    'required' => true,
                    'placeholder' => 'e.g. District Chair',
                    'value' => isset($link) ? $link['title'] : '',
                ])
                <div class="text-sm lg:pt-6">
                    This is the link text.
                </div>
            </div>

            <div class="grid lg:grid-cols-2 gap-3 lg:gap-8">
                @include('common.input', [
                    'label' => 'Target',
                    'name' => 'target',
                    'type' => 'text',
                    'required' => true,
                    'placeholder' => 'e.g. mailto:chair@district.org',
                    'value' => isset($link) ? $link['target'] : '',
                ])
                <div class="text-sm lg:pt-6">
                    This is the link URL.
                </div>
            </div>

            @include('common.submit', [
                'cancel' => route('entities.links.index', $entity),
                'delete' => isset($link) ? route('delete-link', $link) : null,
            ])

        </form>

    </div>

@endsection
