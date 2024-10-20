@extends('layouts.app')

@section('title', isset($story) ? __('Edit Story') : __('Create Story'))

@section('content')

    <div class="max-w-6xl mx-auto px-4 grid gap-8">

        @include('common.alerts')

        @include('common.heading', [
            'title' => isset($story) ? __('Edit Story') : __('Create Story'),
            'breadcrumbs' => auth()->user()->admin
                ? [
                    route('entities.index') => __('Entities'),
                    route('entities.stories.index', $entity) => $entity->name(),
                ]
                : [
                    route('entities.stories.index', $entity) => $entity->name(),
                ],
        ])

        <form method="post" class="grid gap-8"
            action="{{ isset($story) ? route('entities.stories.update', [$entity, $story]) : route('entities.stories.store', $entity) }}"
            x-data="{{ Js::from([
                'language' => old('language', isset($story) ? $story['language'] : $entity['language']),
                'type' => old('type', isset($story) ? $story['type'] : array_keys($types)[0]),
            ]) }}">
            @csrf
            @isset($story)
                @method('put')
            @endisset

            <div class="grid lg:grid-cols-2 gap-3 lg:gap-8 items-center">
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

            <div class="grid lg:grid-cols-2 gap-3 lg:gap-8 items-center">
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

            <div class="grid lg:grid-cols-2 gap-3 lg:gap-8 items-center">
                <div class="grid gap-1 w-full">
                    @include('common.radio', [
                        'label' => __('Type'),
                        'name' => 'type',
                        'required' => true,
                        'options' => $types,
                    ])
                </div>
                <div class="text-sm lg:pt-6">
                    {{ __('Use news for announcements and events, business for motions, discussion topics, or items of deliberation, and resources for websites or special documents.') }}
                </div>
            </div>

            <div class="grid lg:grid-cols-4 gap-3 lg:gap-5 items-center">
                @include('common.input', [
                    'label' => __('Start'),
                    'name' => 'start_at',
                    'type' => 'date',
                    'required' => true,
                    'value' => isset($story) ? $story['start_at']->format('Y-m-d') : $now->format('Y-m-d'),
                ])
                @include('common.input', [
                    'label' => __('End'),
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
                @include('common.radio', [
                    'label' => __('Language'),
                    'name' => 'language',
                    'required' => true,
                    'value' => old('language', isset($story) ? $story['language'] : $entity['language']),
                    'options' => $languages,
                ])
            </div>

            @include('common.submit', [
                'cancel' => route('entities.stories.index', $entity),
                'delete' => isset($story) ? route('delete-story', $story) : null,
            ])

        </form>

        @isset($story)
            @include('common.separator')

            <div class="flex justify-end items-center">
                @include('common.link-button', [
                    'label' => __('Create Button'),
                    'icon' => 'plus',
                    'href' => route('entities.stories.buttons.create', [$entity, $story]),
                ])
            </div>

            @include('common.table', [
                'columns' => [__('Title'), __('Type'), __('Target'), __('Style')],
                'empty' => __('No buttons yet.'),
                'reorder' => route('reorder-buttons', $story),
                'rows' => $story->buttons->map(function ($button) use ($entity, $story) {
                    if (Str::startsWith($button->link, 'mailto:')) {
                        $link = substr($button->link, 7);
                    } elseif (Str::isUrl($button->link)) {
                        $link = parse_url($button->link, PHP_URL_HOST);
                    } else {
                        $link = $button->link;
                    }
            
                    return [
                        'href' => route('entities.stories.buttons.edit', [$entity, $story, $button]),
                        'id' => $button->id,
                        'values' => [$button->title, $button->type, $link, $button->style],
                    ];
                }),
            ])
        @endisset

    </div>

@endsection
