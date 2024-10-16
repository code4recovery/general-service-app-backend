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
            <div class="grid gap-4">
                <h3 class="text-xl font-bold">{{ __('What is General Service?') }}</h3>
                <p>Alcoholics Anonymous is a worldwide group that started in 1935 with the sole purpose of alcoholics
                    helping other alcoholics get and maintain sobriety. This General Service App is intended for usage in
                    the AA U.S./Canada so that volunteers get the information they need to communicate what’s happening in
                    AA.</p>

                <p>The communication structure of Alcoholics Anonymous is represented by an upside-down triangle. The
                    purpose of the structure is two-way communication. This app attempts to provide a unified communication
                    structure by which District Officers, Area Officers and the General Service Office can communicate with
                    Group General Service Representatives about what is happening in AA “as a whole”.</p>

                <p>This website is the mechanism by which to upload user stories that are sorted by News (Announcements &
                    Events); Business (service entity motions and items of discussion); and Resources (local resources where
                    users can find more information).</p>

                <p>Reach out to your Area Delegate for your Area to be <a href="/onboarding"
                        class="text-blue-700 dark:text-blue-300 underline">onboarded into the App</a>.</p>
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
