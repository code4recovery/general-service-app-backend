@extends('layouts.app')

@section('title', isset($entity) ? $entity->name() : 'New Service Entity')

@section('content')

    <div class="container max-w-6xl mx-auto px-4 grid gap-8">

        @include('common.alerts')

        @isset($entity)
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
        @endisset


        <form method="post" class="grid gap-8"
            action="{{ isset($entity) ? route('entities.update', $entity) : route('entities.store') }}">
            @csrf
            @isset($entity)
                @method('put')
            @endisset

            <div class="grid lg:grid-cols-2 gap-3 lg:gap-8">
                @include('common.input', [
                    'label' => 'Location',
                    'name' => 'name',
                    'type' => 'text',
                    'required' => true,
                    'placeholder' => 'e.g. San Francisco',
                    'value' => isset($entity) ? $entity['name'] : '',
                ])
                <div class="text-sm lg:pt-6">
                    This is the geographic location of the Area / District. Don't include the number or any information
                    about the parent.
                </div>
            </div>

            <div class="grid lg:grid-cols-2 gap-3 lg:gap-8">
                <div class="flex gap-5">
                    @include('common.input', [
                        'label' => 'Area',
                        'name' => 'area',
                        'type' => 'number',
                        'value' => isset($entity) ? $entity['area'] : '',
                    ])
                    @include('common.input', [
                        'label' => 'District',
                        'name' => 'district',
                        'type' => 'number',
                        'value' => isset($entity) ? $entity['district'] : '',
                    ])
                </div>
                <div class="text-sm lg:pt-6">
                    The area and district numbers. For example, Area 4, District 101.
                </div>
            </div>

            <div class="grid lg:grid-cols-2 gap-3 lg:gap-8">
                <div class="flex gap-5">
                    @include('common.input', [
                        'label' => 'Banner (Light)',
                        'name' => 'banner',
                        'type' => 'url',
                        'value' => isset($entity) ? $entity['banner'] : '',
                    ])
                    @include('common.input', [
                        'label' => 'Banner (Dark)',
                        'name' => 'banner_dark',
                        'type' => 'url',
                        'value' => isset($entity) ? $entity['banner_dark'] : '',
                    ])
                </div>
                <div class="text-sm lg:pt-6">
                    The banner image for the app. Ideally this would be a JPG 1200x300 pixels. Only needed for Districts.
                </div>
            </div>

            <div class="grid lg:grid-cols-2 gap-3 lg:gap-8">
                @include('common.input', [
                    'label' => 'Website',
                    'name' => 'website',
                    'type' => 'url',
                    'value' => isset($entity) ? $entity['website'] : '',
                ])
                <div class="text-sm lg:pt-6">
                    The service entity's website home page.
                </div>
            </div>

            <div class="grid lg:grid-cols-2 gap-3 lg:gap-8">
                <div class="grid gap-1 w-full">
                    <label for="type" class="block">Language</label>
                    <div class="grid grid-cols-4 gap-8">
                        @foreach ($languages as $lang => $language)
                            <label class="flex items-center gap-2">
                                <input type="radio" name="language" value="{{ $lang }}" required
                                    @if (old('language', isset($entity) ? $entity['language'] : 'en') === $lang) checked @endif />
                                {{ $language }}
                            </label>
                        @endforeach
                    </div>
                </div>
                <div class="text-sm lg:pt-6">
                    Only needed for language-specific districts.
                </div>
            </div>

            @include('common.submit', [
                'cancel' => auth()->user()->admin ? route('entities.index') : null,
                'delete' =>
                    auth()->user()->admin && isset($entity) && $entity->district
                        ? route('delete-entity', $entity)
                        : null,
            ])

        </form>

    </div>

@endsection
