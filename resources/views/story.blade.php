@extends('layouts.app')

@section('title', isset($story) ? __('Edit Story') : __('Create Story'))

@section('content')

    <div class="container max-w-6xl mx-auto px-4 grid gap-4">

        @include('common.alerts')

        @include('common.heading', [
            'title' => isset($story) ? __('Edit Story') : __('Create Story'),
            'breadcrumbs' => auth()->user()->admin
                ? [
                    route('entities.index') => __('Entities'),
                    route('entities.stories.index', $entity->id) => $entity->name(),
                ]
                : [
                    route('entities.stories.index', $entity->id) => $entity->name(),
                ],
        ])

        <form method="post" class="grid gap-8"
            action="{{ isset($story) ? route('entities.stories.update', [$entity, $story]) : route('entities.stories.store', $entity) }}">
            @csrf
            @isset($story)
                @method('put')
            @endisset

            <div class="grid lg:grid-cols-2 gap-3 lg:gap-8">
                @include('common.input', [
                    'label' => __('Title'),
                    'name' => 'title',
                    'type' => 'text',
                    'required' => true,
                    'value' => isset($story) ? $story['title'] : '',
                ])
                <div class="text-sm lg:pt-6">
                    {{ __('This is the headline of your story.') }}
                </div>
            </div>

            <div class="grid lg:grid-cols-2 gap-3 lg:gap-8">
                @include('common.input', [
                    'label' => __('Description'),
                    'name' => 'description',
                    'type' => 'textarea',
                    'required' => true,
                    'value' => isset($story) ? $story['description'] : '',
                ])
                <div class="text-sm lg:pt-6">
                    {{ __('This is the content of your story. This is plain text only because apps have trouble displaying rich text.') }}
                </div>
            </div>

            <div class="grid lg:grid-cols-2 gap-3 lg:gap-8">
                <div class="grid gap-1 w-full">
                    <label for="type" class="block">{{ __('Type') }}</label>
                    <div class="grid grid-cols-2 gap-8">
                        @foreach ($types as $type)
                            <label class="flex items-center gap-2">
                                <input type="radio" name="type" value="{{ $type }}" required
                                    @if (old('type', isset($story) ? $story['type'] : '') === $type) checked @endif />
                                {{ __(ucfirst($type)) }}
                            </label>
                        @endforeach
                    </div>
                </div>
                <div class="text-sm lg:pt-6">
                    {{ __('Announcements are for general news and updates. Events are for a specific date and time.') }}
                </div>
            </div>

            <div class="grid lg:grid-cols-4 gap-3 lg:gap-8">
                @include('common.input', [
                    'label' => __('Start Date'),
                    'name' => 'start_at',
                    'type' => 'date',
                    'required' => true,
                    'value' => isset($story) ? $story['start_at']->format('Y-m-d') : $now->format('Y-m-d'),
                ])
                @include('common.input', [
                    'label' => __('End Date'),
                    'name' => 'end_at',
                    'type' => 'date',
                    'required' => true,
                    'value' => isset($story)
                        ? $story['end_at']->format('Y-m-d')
                        : $now->add(2, 'months')->format('Y-m-d'),
                ])
                <div class="lg:col-span-2 text-sm lg:pt-6">
                    {{ __('First and last dates to display the story.') }}
                </div>
            </div>

            <div class="grid lg:grid-cols-2 gap-3 lg:gap-8">
                <div class="grid gap-1 w-full">
                    <label for="type" class="block">{{ __('Language') }}</label>
                    <div class="grid grid-cols-4 gap-8">
                        @foreach ($languages as $lang => $language)
                            <label class="flex items-center gap-2">
                                <input type="radio" name="language" value="{{ $lang }}" required
                                    @if (old('language', isset($entity) ? $entity['language'] : 'en') === $lang) checked @endif>
                                {{ $language }}
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            @include('common.submit', [
                'cancel' => route('entities.stories.index', $entity),
                'delete' => isset($story) ? route('delete-story', $story) : null,
            ])

        </form>

        @isset($story)
            <hr class="my-8 border-gray-500 border-dashed">

            <div class="flex justify-end items-center">
                @include('common.link-button', [
                    'label' => __('Create Button'),
                    'icon' => 'plus',
                    'href' => '#buttons',
                ])
            </div>

            @include('common.table', [
                'columns' => [__('Title'), __('Type'), __('Target'), __('Style')],
                'empty' => __('No buttons yet.'),
                'rows' => $story->buttons->map(function ($button) {
                    return [
                        'href' => '#',
                        'id' => $button->id,
                        'values' => [
                            $button->title,
                            $button->type,
                            parse_url($button->link)['host'],
                            $button->style,
                        ],
                    ];
                }),
            ])
        @endisset


    </div>

@endsection
