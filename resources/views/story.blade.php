@extends('layouts.app')

@section('title', $story ? 'Edit Story' : 'Create Story')

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
                    'value' => $story['title'] ?? '',
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
                    'value' => $story['description'] ?? '',
                ])
                <div class="text-sm lg:pt-6">
                    This is the content of your story. This is plain text only because apps have trouble displaying
                    rich text.
                </div>
            </div>

            <div class="grid lg:grid-cols-4 gap-3 lg:gap-8">
                @include('common.input', [
                    'label' => 'Effective Date',
                    'name' => 'effective_at',
                    'type' => 'date',
                    'required' => true,
                    'value' => $story ? $story['effective_at']->format('Y-m-d') : $now->format('Y-m-d'),
                ])
                @include('common.input', [
                    'label' => 'Expire Date',
                    'name' => 'expire_at',
                    'type' => 'date',
                    'required' => true,
                    'value' => $story
                        ? $story['expire_at']->format('Y-m-d')
                        : $now->add(2, 'months')->format('Y-m-d'),
                ])
                <div class="lg:col-span-2 text-sm lg:pt-6">
                    First and last dates to display the story.
                </div>
            </div>

            @foreach (['1', '2', '3'] as $button)
                <div class="grid lg:grid-cols-4 gap-3 lg:gap-8">
                    @include('common.input', [
                        'label' => "Button $button Label",
                        'name' => "buttons[$button][link]",
                        'type' => 'text',
                        'placeholder' => 'View Flyer',
                    ])
                    @include('common.input', [
                        'label' => "Button $button Link",
                        'name' => "buttons[$button][link]",
                        'type' => 'url',
                        'placeholder' => "https://intergroup.org/img/flyer-$button.pdf",
                    ])
                    <div class="lg:col-span-2 text-sm lg:pt-6">
                        An optional "call-to-action" button to go below your story. To be valid, a button must have
                        both a URL and label text.
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
