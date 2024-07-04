@extends('layouts.app')

@section('title', isset($story) ? __('Edit Story') : __('Create Story'))

@section('content')

    <div class="container max-w-6xl mx-auto px-4 grid gap-4">

        @include('common.alerts')

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

            @foreach ($buttons as $button)
                @isset($story['buttons'][$button])
                    <input type="hidden" name="buttons[{{ $button }}][id]"
                        value="{{ $story['buttons'][$button]['id'] }}" />
                @endisset
                <div class="grid lg:grid-cols-4 gap-3 lg:gap-8">
                    @include('common.input', [
                        'label' => __('Button Title'),
                        'name' => "buttons[$button][title]",
                        'type' => 'text',
                        'placeholder' => __('View Flyer'),
                        'value' => $story['buttons'][$button]['title'] ?? '',
                    ])
                    @include('common.input', [
                        'label' => __('Button Link'),
                        'name' => "buttons[$button][link]",
                        'type' => 'url',
                        'placeholder' => "https://district.org/img/flyer-$button.pdf",
                        'value' => $story['buttons'][$button]['link'] ?? '',
                    ])
                    <div class="lg:col-span-2 text-sm lg:pt-6">
                        @if ($loop->first)
                            <p>
                                {{ __('Optional “call-to-action” buttons to go below your story. Buttons need both a title and a link.') }}
                            </p>
                        @endif
                    </div>
                </div>
            @endforeach

            @include('common.submit', [
                'cancel' => route('entities.stories.index', $entity),
                'delete' => isset($story) ? route('delete-story', $story) : null,
            ])

        </form>

    </div>

@endsection
