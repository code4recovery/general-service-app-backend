@extends('layouts.app')

@section('title', $district->name)

@section('description', 'View stories')

@section('content')

    <div class="container max-w-6xl mx-auto px-4 grid gap-4">

        <div class="flex items-center justify-between w-full">
            <h1 class="text-2xl font-bold">
                {{ str_pad($district->number, 2, '0', STR_PAD_LEFT) }}:
                {{ $district->name }}
            </h1>
            <a href="/stories/{{ $district->area_id }}/{{ $district->number }}/create"
                class="bg-gray-300 hover:bg-gray-400 dark:bg-gray-400 dark:hover:bg-white py-2 px-6 rounded font-semibold text-gray-900">
                Create
            </a>
        </div>

        @if ($district->stories->isEmpty())
            <p>No stories yet.</p>
        @endif

        @foreach ($district->stories as $story)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-8">
                <h2 class="text-xl font-bold">{{ $story->title }}</h2>
                <p>{{ $story->content }}</p>
            </div>
        @endforeach

    </div>

@endsection
