@extends('layouts.app')

@section('title', __('General Service App'))

@section('description', __('An app designed for A.A. General Service'))

@section('content')

    <div class="max-w-6xl mx-auto px-4 grid lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 grid gap-10 content-start">
            <div class="flex gap-4 justify-center md:justify-start">
                <a href="https://apps.apple.com/us/app/general-service/id6670377389">
                    <img src="{{ asset('download-apple.svg') }}" alt="App Store" class="w-44 block pointer-events-none">
                </a>
                <a href="https://play.google.com/store/apps/details?id=app.generalservice">
                    <img src="{{ asset('download-google.svg') }}" alt="Google Play" class="w-44 block pointer-events-none">
                </a>
            </div>
            <div class="grid gap-4 leading-7">
                <h3 class="text-3xl font-bold mb-3">{{ __('Carry the message') }}</h3>
                <p>
                    {{ __('Alcoholics Anonymous is a worldwide fellowship that started in 1935 with the sole purpose of alcoholics helping other alcoholics get and maintain sobriety. This General Service App is intended for usage in the A.A. U.S./Canada service structure so that volunteers get the information they need to communicate what’s happening in A.A.') }}
                </p>

                <p>
                    {{ __('The communication structure of Alcoholics Anonymous is represented by an upside-down triangle. The purpose of the structure is two-way communication. This app provides a unified communication system by which District Officers, Area Officers and the General Service Office can communicate with Group General Service Representatives about what is happening in A.A. as a whole.') }}
                </p>

                <p>
                    {!! __(
                        'Reach out to your Area Delegate for your Area to be onboarded into the app. Once your area is added, you will receive an email for you to <a :link>get started</a>.',
                        ['link' => 'href="/get-started" class="' . $link_css . '"'],
                    ) !!}
                </p>
            </div>
            <ul class="grid grid-cols-2 gap-4 md:grid-cols-4 mt-3">
                @foreach ([
            'gift' => __('Free of Charge'),
            'eye-slash' => __('No Tracking'),
            'moon' => __('Light / Dark Modes'),
            'language' => __('English, French, and Spanish'),
        ] as $navicon => $navtext)
                    <li
                        class="py-6 grid gap-2 rounded-xl justify-items-center text-center text-sm flex-grow basis-1 flex-1 bg-black/5 dark:bg-white/10">
                        @include('common.icon', ['icon' => $navicon, 'size' => 'size-8'])
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
