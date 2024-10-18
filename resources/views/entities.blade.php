@extends('layouts.app')

@section('title', __('Users'))

@section('content')

    <div class="container max-w-6xl mx-auto px-4 grid gap-8">

        @include('common.alerts')

        @include('common.heading', [
            'title' => __('Entities'),
        ])

        <div @class(['divide-y divide-gray-300 dark:divide-gray-600', $border_css])>
            @foreach ($areas as $area)
                <div class="py-3 flex flex-wrap gap-3 items-center p-3">
                    <a href="{{ route('entities.stories.index', $area->id) }}" class="hover:underline">
                        {{ $area->name() }}
                    </a>
                    @foreach ($area->users as $user)
                        @include('common.user-chiclet', ['user' => $user, 'entity' => $area])
                    @endforeach
                    @if (count($area->users) < 3 && ($area->districts || !$area->area))
                        @livewire('email-form', ['entity' => $area->id])
                    @endif
                </div>
            @endforeach
        </div>

    </div>

@endsection
