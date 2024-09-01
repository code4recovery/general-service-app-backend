@extends('layouts.app')

@section('title', __('General Service App'))

@section('description', __('An app designed for A.A. General Service'))

@section('content')

    <div class="container max-w-6xl mx-auto px-4 grid lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 grid gap-10 content-start">
            <div class="grid gap-4">
                <h2 class="text-2xl font-light">{{ __('Carry the message to your groups.') }}</h2>
                <p>
                    {{ __('District Chairs are welcome to use this free service to provide local news and event information to General Service Representatives.') }}
                </p>
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
            'gift' => __('Free of Charge'),
            'eye-slash' => __('No Tracking'),
            'moon' => __('Light / Dark Modes'),
            'language' => __('English, French, and Spanish'),
        ] as $navicon => $navtext)
                    <li
                        class="py-10 px-3 border border-gray-300 dark:border-gray-600 grid gap-2 justify-items-center text-center">
                        @include('common.icon', ['icon' => $navicon, 'size' => 'size-12'])
                        {{ $navtext }}
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="lg:-mr-3">
            <img src="{{ asset('screenshot-light.png') }}" width="800" height="1583" alt=""
                class="h-auto max-w-full block dark:hidden">
            <img src="{{ asset('screenshot-dark.png') }}" width="800" height="1583" alt=""
                class="h-auto max-w-full hidden dark:block">
        </div>
    </div>

@endsection
