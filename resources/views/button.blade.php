@extends('layouts.app')

@section('title', isset($button) ? __('Edit Button') : __('Create Button'))

@section('content')

    <div class="container max-w-6xl mx-auto px-4 grid gap-8">

        @include('common.alerts')

        @include('common.heading', [
            'title' => isset($button) ? __('Edit Button') : __('Create Button'),
            'breadcrumbs' => auth()->user()->admin
                ? [
                    route('entities.index') => __('Entities'),
                    route('entities.stories.index', $entity) => $entity->name(),
                    route('entities.stories.edit', [$entity, $story]) => $story->title,
                ]
                : [
                    route('entities.stories.index', $entity) => $entity->name(),
                    route('entities.stories.edit', [$entity, $story]) => $story->title,
                ],
            'button' => null,
        ])

        <form x-cloak method="post" class="grid gap-8" x-data="{{ Js::from([
            'type' => old('type', isset($button) ? $button['type'] : 'link'),
        ]) }}"
            action="{{ isset($button) ? route('entities.stories.buttons.update', [$entity, $story, $button]) : route('entities.stories.buttons.store', [$entity, $story]) }}">
            @csrf
            @isset($button)
                @method('put')
            @endisset

            <div class="grid lg:grid-cols-2 gap-3 lg:gap-8 items-center">
                @include('common.radio', [
                    'label' => __('Type'),
                    'name' => 'type',
                    'options' => [
                        'link' => __('Link'),
                        'calendar' => __('Add to Calendar'),
                    ],
                    'value' => old('type', isset($button) ? $button['type'] : 'link'),
                ])
                <div class="text-sm lg:pt-6">
                </div>
            </div>

            <div class="grid lg:grid-cols-2 gap-3 lg:gap-8 items-center">
                @include('common.input', [
                    'label' => __('Title'),
                    'name' => 'title',
                    'type' => 'text',
                    'required' => true,
                    'value' => isset($button) ? $button['title'] : '',
                ])
                <div class="text-sm lg:pt-6">
                    {{ __('This is the button text.') }}
                </div>
            </div>

            <div class="grid lg:grid-cols-2 gap-3 lg:gap-8 items-center" x-show="type === 'link'">
                @include('common.input', [
                    'label' => __('Link'),
                    'name' => 'link',
                    'type' => 'text',
                    // 'required' => true,
                    'value' => isset($button) ? $button['link'] : '',
                ])
                <div class="text-sm lg:pt-6">
                    {{ __('This is the URL the button will link to. Must start with `https`') }}
                </div>
            </div>

            <div class="grid lg:grid-cols-2 gap-3 lg:gap-8 items-center" x-show="type === 'calendar'">
                <div class="grid lg:grid-cols-2 gap-3">
                    @include('common.input', [
                        'label' => __('Start'),
                        'name' => 'start',
                        'type' => 'datetime-local',
                        'required' => true,
                        'value' => !empty($button['start']) ? $button['start'] : '2018-06-12T19:30',
                    ])
                    @include('common.input', [
                        'label' => __('End'),
                        'name' => 'end',
                        'type' => 'datetime-local',
                        'required' => true,
                        'value' => !empty($button['end']) ? $button['end'] : '2018-06-12T19:30',
                    ])
                </div>
            </div>

            <div class="grid lg:grid-cols-2 gap-3 lg:gap-8 items-center" x-show="type === 'calendar'">
                <div class="grid lg:grid-cols-2 gap-3">
                    @include('common.input', [
                        'label' => __('Conference URL'),
                        'name' => 'conference_url',
                        'type' => 'url',
                        'value' => !empty($button['conference_url']) ? $button['conference_url'] : null,
                        'placeholder' => 'https://zoom.us/j/1234567890',
                    ])
                    @include('common.input', [
                        'label' => __('Full Address'),
                        'name' => 'formatted_address',
                        'type' => 'text',
                        'value' => !empty($button['formatted_address']) ? $button['formatted_address'] : null,
                        'placeholder' => __('123 Main St, San Francisco, CA 94111'),
                    ])
                </div>
                <div class="text-sm lg:pt-6">
                    {{ __('Conference URL should be a one-click join link to a service such as Zoom.') }}
                </div>
            </div>

            <div class="grid lg:grid-cols-2 gap-3 lg:gap-8 items-center" x-show="type === 'calendar'">
                @include('common.input', [
                    'label' => __('Notes'),
                    'name' => 'notes',
                    'type' => 'textarea',
                    'value' => !empty($button['notes']) ? $button['notes'] : null,
                ])
            </div>

            @include('common.submit', [
                'cancel' => route('entities.stories.edit', [$entity, $story]),
                'delete' => isset($button) ? route('delete-button', $button) : null,
            ])

        </form>

    </div>

@endsection
