@extends('layouts.app')

@section('title', 'General Service App')

@section('description', 'An app designed for A.A. General Service')

@section('content')

    <div class="container max-w-6xl mx-auto px-4 grid lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            <h2 class="mt-4 text-2xl font-light">Carry the message to your groups.</h2>
            <p class="mt-4">District Chairs (DCMs and DCMCs) are invited to use this free service to provide local
                news and event information to General Service Representatives.</p>
            <h3 class="mt-4">Feature Overview</h3>
            <ul class="list-disc pl-5">
                <li>Free</li>
                <li>Private</li>
                <li>Dark mode</li>
                <li>Native support for English, Spanish, and French</li>
                <li>Available on Android and iOS</li>
            </ul>
            <div class="mt-7 flex gap-4">
                <a href="https://apps.apple.com/us/app/aa-general-service/id1580190136"
                    class="block dark:ring-gray-600 dark:hover:ring-gray-400 ring-1 rounded-md">
                    <img src="{{ asset('download-apple-new.svg') }}" alt="App Store" class="h-14 block pointer-events-none">
                </a>
                <a href="https://play.google.com/store/apps/details?id=com.aa.generalservice"
                    class="block dark:ring-gray-600 dark:hover:ring-gray-400 ring-1 rounded-md">
                    <img src="{{ asset('download-google-new.svg') }}" alt="Google Play"
                        class="h-14 block pointer-events-none">
                </a>
            </div>
        </div>
        <div>
            <img src="{{ asset('screenshot.png') }}" alt="Hero" class="h-auto max-w-full">
        </div>
    </div>

@endsection
