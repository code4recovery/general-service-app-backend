@extends('layouts.app')

@section('title', 'Verify Your Email')

@section('description', 'Verify your email to log in.')

@section('content')

    <div class="container max-w-3xl mx-auto px-4 grid gap-4">

        @foreach ($user->districts as $district)
            <h1 class="text-2xl font-bold">
                {{ str_pad($district->number, 2, '0', STR_PAD_LEFT) }}:
                {{ $district->name }}
            </h1>

            @foreach ($district->stories as $story)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-8">
                    <h2 class="text-xl font-bold">{{ $story->title }}</h2>
                    <p>{{ $story->content }}</p>
                </div>
            @endforeach
        @endforeach

    </div>

@endsection
