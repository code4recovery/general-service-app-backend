@extends('layouts.app')

@section('title', isset($entity) ? $entity->name() : __('Create Entity'))

@section('content')

    <div class="container max-w-6xl mx-auto px-4 grid gap-8">

        @include('common.alerts')

        @include('common.heading', [
            'title' => isset($entity) ? $entity->name() : __('Create Entity'),
            'breadcrumbs' => auth()->user()->admin
                ? [
                    route('entities.index') => __('Entities'),
                ]
                : [],
        ])

        @isset($entity)
            @include('common.nav', [
                'links' => [
                    route('entities.stories.index', $entity) => ['newspaper', __('Stories')],
                    route('entities.links.index', $entity) => ['chat-bubble-oval-left', __('Links')],
                    route('entities.edit', $entity) => ['cog', __('Settings')],
                ],
            ])
        @endisset


        <form method="post" class="grid gap-8"
            action="{{ isset($entity) ? route('entities.update', $entity) : route('entities.store') }}"
            x-data="{{ Js::from([
                'language' => old('language', !empty($entity['language']) ? $entity['language'] : 'en'),
            ]) }}">
            @csrf
            @isset($entity)
                @method('put')
            @endisset

            <div class="grid lg:grid-cols-2 gap-3 lg:gap-8 items-center">
                @include('common.input', [
                    'label' => __('Name'),
                    'name' => 'name',
                    'type' => 'text',
                    'required' => true,
                    'placeholder' => __('e.g. San Francisco'),
                    'value' => isset($entity) ? $entity['name'] : '',
                ])
                <div class="text-sm lg:pt-6">
                    {!! __('For example, <code>District 06: San Francisco</code>') !!}
                </div>
            </div>

            <div class="grid lg:grid-cols-2 gap-3 lg:gap-8 items-center">
                <div class="flex gap-5">
                    @include('common.input', [
                        'label' => __('Area'),
                        'name' => 'area',
                        'type' => 'number',
                        'value' => isset($entity) ? $entity['area'] : '',
                    ])
                    @include('common.input', [
                        'label' => __('District'),
                        'name' => 'district',
                        'type' => 'text',
                        'value' => isset($entity) ? $entity['district'] : '',
                    ])
                </div>
                <div class="text-sm lg:pt-6">
                    {{ __('The area and district numbers. For example, Area 4, District 20.') }}
                </div>
            </div>

            <div class="grid lg:grid-cols-2 gap-3 lg:gap-8 items-center">
                <div class="flex gap-5">
                    @include('common.input', [
                        'label' => __('App Banner (Light)'),
                        'name' => 'banner',
                        'type' => 'url',
                        'value' => isset($entity) ? $entity['banner'] : '',
                    ])
                    @include('common.input', [
                        'label' => __('App Banner (Dark)'),
                        'name' => 'banner_dark',
                        'type' => 'url',
                        'value' => isset($entity) ? $entity['banner_dark'] : '',
                    ])
                </div>
                <div class="text-sm lg:pt-6">
                    {{ __('These should be 1200×300 JPGs, under 100kb. Black text should be legible above the light version, and white text above the dark version.') }}
                </div>
            </div>

            <div class="grid lg:grid-cols-2 gap-3 lg:gap-8">
                @include('common.input', [
                    'label' => __('Website'),
                    'name' => 'website',
                    'type' => 'url',
                    'value' => isset($entity) ? $entity['website'] : '',
                ])
            </div>

            <div class="grid lg:grid-cols-2 gap-3 lg:gap-8">
                @include('common.radio', [
                    'label' => __('Language'),
                    'name' => 'language',
                    'options' => $languages,
                ])
            </div>

            <div class="grid lg:grid-cols-2 gap-3 lg:gap-8">
                <div class="flex gap-5">
                    @include('common.timezone', [
                        'label' => __('Timezone'),
                        'name' => 'timezone',
                        'value' => old('timezone', isset($entity) ? $entity['timezone'] : 'America/Los_Angeles'),
                    ])
                    @if (!empty($entity->area) && empty($entity->district))
                        @include('common.input', [
                            'label' => __('Map ID'),
                            'name' => 'map_id',
                            'type' => 'text',
                            'value' => old('map_id', isset($entity) ? $entity['map_id'] : null),
                        ])
                    @endif
                </div>
            </div>


            @include('common.submit', [
                'cancel' => auth()->user()->admin ? route('entities.index') : null,
            ])

        </form>

    </div>

@endsection
