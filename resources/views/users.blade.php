@extends('layouts.app')

@section('title', __('Users'))

@section('content')

    <div class="container max-w-6xl mx-auto px-4 grid gap-8">

        @include('common.alerts')

        @include('common.heading', [
            'title' => __('Users'),
        ])

        <section class="grid gap-3 mb-6">
            <h2 class="font-bold text-xl">Site Admins</h2>

            <div class="flex flex-wrap flex-row gap-4">
                @foreach ($admins as $admin)
                    @include('common.user-chiclet', ['user' => $admin])
                @endforeach
                @livewire('email-form')
            </div>
        </section>

        <section>
            <h2 class="font-bold text-xl">Area Chairs, Delegates, and Alternates</h2>

            <div class="divide-y divide-gray-300 dark:divide-gray-600">
                @foreach ($areas as $area)
                    <div class="py-3 flex flex-wrap gap-3 items-center">
                        <a href="{{ route('entities.stories.index', $area->id) }}" class="hover:underline">
                            {{ $area->area() }}: {{ $area->name }}
                        </a>
                        @foreach ($area->users as $user)
                            @include('common.user-chiclet', ['user' => $user, 'entity' => $area])
                        @endforeach
                        @if ($area->districts)
                            @livewire('email-form', ['entity' => $area->id])
                        @endif
                    </div>
                @endforeach
            </div>
        </section>

    </div>

@endsection
