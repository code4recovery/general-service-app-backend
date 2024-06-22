@extends('layouts.app')

@section('title', 'General Service App')

@section('description', 'An app designed for A.A. General Service')

@section('content')

    <div class="container max-w-6xl mx-auto px-4 grid lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 grid gap-10 content-start">
            <div class="grid gap-4">
                <h2 class="text-2xl font-light">Carry the message to your groups.</h2>
                <p>
                    District Chairs (DCMs and DCMCs) are invited to use this free service to provide local
                    news and event information to General Service Representatives.</p>
            </div>
            <div class="flex gap-4">
                <a href="https://apps.apple.com/us/app/aa-general-service/id1580190136">
                    <img src="{{ asset('download-apple.svg') }}" alt="App Store" class="h-14 block pointer-events-none">
                </a>
                <a href="https://play.google.com/store/apps/details?id=com.aa.generalservice">
                    <img src="{{ asset('download-google.svg') }}" alt="Google Play" class="h-14 block pointer-events-none">
                </a>
            </div>
            <ul class="grid grid-cols-2">
                @foreach ([
            'gift' => 'Free of Charge',
            'eye-slash' => 'No Tracking',
            'moon' => 'Light / Dark Modes',
            'language' => 'English, French, and Spanish',
        ] as $navicon => $navtext)
                    <li
                        class="py-10 px-3 border border-gray-300 dark:border-gray-600 grid gap-2 justify-items-center text-center">
                        @include('common.icon', ['icon' => $navicon, 'size' => 'size-12'])
                        {{ $navtext }}
                    </li>
                @endforeach
            </ul>
            <div class="grid gap-3">
                <h3 class="font-bold text-xl">
                    Participating Service Entities
                </h3>
                <ol class="list-decimal pl-5">
                    @foreach ($entities as $entity)
                        <li>
                            @if ($entity->website)
                                <a href="{{ $entity->website }}" class="text-blue-500 dark:text-white hover:underline"
                                    target="_blank">
                                    {{ $entity->name() }}
                                </a>
                            @else
                                {{ $entity->name() }}
                            @endif
                        </li>
                    @endforeach
                </ol>
            </div>
        </div>
        <div class="lg:-mr-3">
            <img src="{{ asset('screenshot-light.png') }}" alt="Hero" class="h-auto max-w-full block dark:hidden">
            <img src="{{ asset('screenshot-dark.png') }}" alt="Hero" class="h-auto max-w-full hidden dark:block">
        </div>
    </div>

@endsection
