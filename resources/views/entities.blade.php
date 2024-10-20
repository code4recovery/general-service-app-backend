@extends('layouts.app')

@section('title', __('Users'))

@section('content')

    <div class="max-w-6xl mx-auto px-4 grid gap-8">

        @include('common.alerts')

        @include('common.heading', [
            'title' => __('Entities'),
        ])

        <div class="divide-y divide-gray-300 dark:divide-gray-600">
            @foreach ($areas as $area)
                <livewire:entity-row :entity="$area" :active="$area->districts || !$area->area" />
            @endforeach
        </div>

    </div>

@endsection
