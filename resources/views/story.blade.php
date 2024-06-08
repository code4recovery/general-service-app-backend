@extends('layouts.app')

@section('title', isset($story) ? 'Edit Story' : 'Create Story')

@section('content')

    <div class="container max-w-6xl mx-auto px-4 grid gap-4">

        @include('common.errors')

        <form method="post" class="grid gap-8">
            @csrf

            <div class="grid lg:grid-cols-2 gap-3 lg:gap-8">
                @include('common.input', [
                    'label' => 'Title',
                    'name' => 'title',
                    'type' => 'text',
                    'required' => true,
                    'value' => isset($story) ? $story['title'] : '',
                ])
                <div class="text-sm lg:pt-6">
                    This is the headline of your story.
                </div>
            </div>

            <div class="grid lg:grid-cols-2 gap-3 lg:gap-8">
                @include('common.input', [
                    'label' => 'Description',
                    'name' => 'description',
                    'type' => 'textarea',
                    'required' => true,
                    'value' => isset($story) ? $story['description'] : '',
                ])
                <div class="text-sm lg:pt-6">
                    This is the content of your story. This is plain text only because apps have trouble displaying
                    rich text.
                </div>
            </div>

            <div class="grid lg:grid-cols-2 gap-3 lg:gap-8">
                <div class="grid gap-1 w-full">
                    <label for="type" class="block">Type</label>
                    <div class="grid grid-cols-2 gap-8">
                        @foreach (['announcement', 'event'] as $type)
                            <label class="flex items-center gap-2">
                                <input type="radio" name="type" value="{{ $type }}" required
                                    @if (old('type') === $type) checked @endif />
                                {{ ucfirst($type) }}
                            </label>
                        @endforeach
                    </div>
                </div>
                <div class="text-sm lg:pt-6">
                    Users can filter stories in the app by type. Announcements are for general news and updates. Events are
                    for a specific date and time.
                </div>
            </div>

            <div class="grid lg:grid-cols-4 gap-3 lg:gap-8">
                @include('common.input', [
                    'label' => 'Effective Date',
                    'name' => 'effective_at',
                    'type' => 'date',
                    'required' => true,
                    'value' => isset($story) ? $story['effective_at']->format('Y-m-d') : $now->format('Y-m-d'),
                ])
                @include('common.input', [
                    'label' => 'Expire Date',
                    'name' => 'expire_at',
                    'type' => 'date',
                    'required' => true,
                    'value' => isset($story)
                        ? $story['expire_at']->format('Y-m-d')
                        : $now->add(2, 'months')->format('Y-m-d'),
                ])
                <div class="lg:col-span-2 text-sm lg:pt-6">
                    First and last dates to display the story.
                </div>
            </div>

            @foreach ([0, 1, 2] as $button)
                @isset($story['buttons'][$button - 1])
                    <input type="hidden" name="buttons[{{ $button }}][id]"
                        value="{{ $story['buttons'][$button]['id'] }}" />
                @endisset
                <div class="grid lg:grid-cols-4 gap-3 lg:gap-8">
                    @include('common.input', [
                        'label' => 'Button Title',
                        'name' => "buttons[$button][title]",
                        'type' => 'text',
                        'placeholder' => 'View Flyer',
                        'value' => $story['buttons'][$button]['title'] ?? '',
                    ])
                    @include('common.input', [
                        'label' => 'Button Link',
                        'name' => "buttons[$button][link]",
                        'type' => 'url',
                        'placeholder' => "https://district.org/img/flyer-$button.pdf",
                        'value' => $story['buttons'][$button]['link'] ?? '',
                    ])
                    <div class="lg:col-span-2 text-sm lg:pt-6">
                        @if ($loop->first)
                            Optional “call-to-action” buttons to go below your story. Buttons need
                            both a title and a link.
                        @endif
                    </div>
                </div>
            @endforeach

            @include('common.submit', [
                'buttons' => [
                    route('district', [$district->area_id, $district->number]) => 'Cancel',
                ],
            ])

        </form>

    </div>

@endsection
