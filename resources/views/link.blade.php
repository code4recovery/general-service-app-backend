@extends('layouts.app')

@section('title', isset($link) ? __('Edit Link') : __('Create Link'))

@section('description', 'Create or edit a link.')

@section('content')

    <div class="container max-w-6xl mx-auto px-4 grid gap-8">

        @include('common.alerts')

        @include('common.heading', [
            'title' => isset($link) ? __('Edit Link') : __('Create Link'),
            'breadcrumbs' => auth()->user()->admin
                ? [
                    route('entities.index') => __('Entities'),
                    route('entities.links.index', $entity) => $entity->name(),
                ]
                : [
                    route('entities.links.index', $entity) => $entity->name(),
                ],
        ])

        @include('common.nav', [
            'links' => [
                route('entities.stories.index', $entity) => ['newspaper', __('Stories')],
                route('entities.links.index', $entity) => ['chat-bubble-oval-left', __('Links')],
                route('entities.edit', $entity) => ['cog', __('Settings')],
            ],
        ])

        <form method="post" class="grid gap-8"
            action="{{ isset($link) ? route('entities.links.update', [$entity, $link]) : route('entities.links.store', $entity) }}">
            @csrf
            @isset($link)
                @method('put')
            @endisset

            <div class="grid lg:grid-cols-2 gap-3 lg:gap-8 items-center">
                @include('common.input', [
                    'label' => __('Title'),
                    'name' => 'title',
                    'type' => 'text',
                    'required' => true,
                    'placeholder' => __('e.g. District Chair'),
                    'value' => isset($link) ? $link['title'] : '',
                ])
                <div class="text-sm lg:pt-6">
                    {{ __('This is the link text.') }}
                </div>
            </div>

            <div class="grid lg:grid-cols-2 gap-3 lg:gap-8 items-center">
                @include('common.input', [
                    'label' => __('Target'),
                    'name' => 'target',
                    'type' => 'text',
                    'required' => true,
                    'placeholder' => __('e.g. mailto:chair@district.org'),
                    'value' => isset($link) ? $link['target'] : '',
                ])
                <div class="text-sm lg:pt-6">
                    {{ __('This is the link URL.') }}
                </div>
            </div>

            @include('common.submit', [
                'cancel' => route('entities.links.index', $entity),
                'delete' => isset($link) ? route('delete-link', $link) : null,
            ])

        </form>

    </div>

@endsection
