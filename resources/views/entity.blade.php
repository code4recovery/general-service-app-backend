@extends('layouts.app')

@section('title', isset($entity) ? $entity->name() : __('Create Entity'))

@section('content')

    <div class="max-w-6xl mx-auto px-4 grid gap-8">

        @include('common.alerts')

        @include('common.heading', [
            'title' => $entity->name(),
            'breadcrumbs' => $breadcrumbs,
        ])

        @include('common.nav', [
            'links' => array_merge(
                [
                    route('entities.stories.index', $entity) => ['newspaper', __('Stories')],
                    route('entities.edit', $entity) => ['cog', __('Settings')],
                ],
                isset($entity->area) && !isset($entity->district)
                    ? [
                        route('districts', $entity) => ['home', __('Districts')],
                    ]
                    : []),
        ])

        <form method="post" class="grid gap-8" enctype="multipart/form-data"
            action="{{ isset($entity) ? route('entities.update', $entity) : route('entities.store') }}"
            x-data="{{ Js::from([
                'language' => old('language', !empty($entity['language']) ? $entity['language'] : 'en'),
            ]) }}">
            @csrf
            @isset($entity)
                @method('put')
            @endisset

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
                @include('common.input', [
                    'label' => __('Name'),
                    'name' => 'name',
                    'type' => 'text',
                    'placeholder' => __('e.g. San Francisco'),
                    'value' => isset($entity) ? $entity['name'] : '',
                ])
                <div class="text-sm lg:pt-6">
                    {!! __('For example, <code>District 06: San Francisco</code>') !!}
                </div>
            </div>

            <div class="grid lg:grid-cols-2 gap-3 lg:gap-8 items-center">
                <div class="grid grid-cols-2 gap-5">
                    @foreach (['banner' => __('App Banner (Light)'), 'banner_dark' => __('App Banner (Dark)')] as $banner_key => $banner_label)
                        <div class="grid gap-1">
                            <label for="{{ $banner_key }}">{{ $banner_label }}</label>
                            @if ($entity->$banner_key)
                                <img src="{{ $entity->$banner_key }}" class="w-full h-auto rounded block" alt="">
                            @endif
                            <input type="file" id="{{ $banner_key }}" name="{{ $banner_key }}" accept="image/jpeg"
                                class="w-full">
                        </div>
                    @endforeach
                </div>
                <div class="text-sm lg:pt-6">
                    {!! __('<a :link>unsplash.com</a> is a good resource for free images.', [
                        'link' =>
                            'href="https://unsplash.com/" target="_blank" rel="noopener noreferrer" class="text-blue-700 dark:text-blue-300"',
                    ]) !!}
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

        @if (count($districts))
            @include('common.separator')

            @include('common.table', [
                'columns' => [__('Name'), __('Language'), __('Stories'), __('Users')],
                'rows' => $districts->map(function ($district) use ($languages) {
                    return [
                        'href' => route('entities.edit', $district),
                        'id' => $district->id,
                        'values' => [
                            $district->name(),
                            $languages[$district->language],
                            $district->stories->count() ?: '',
                            $district->users->count() ?: '',
                        ],
                    ];
                }),
            ])
        @endif

    </div>

@endsection
