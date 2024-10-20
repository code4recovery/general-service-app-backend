@extends('layouts.app')

@section('title', 'General Service App')

@section('description', 'An app designed for A.A. General Service')

@section('content')

    <div class="max-w-3xl mx-auto px-4 grid gap-4">

        @include('common.heading', [
            'title' => 'Privacy Policy',
        ])

        <p>Effective date: June 2, 2024</p>

        <p>The General Service App does not use third-party analytics software on the website or in the app.</p>

        <p>The General Service App does not collect any personal information from users.</p>

        <p>When app users "find their district" using their location, the location does not leave the app. All processing is
            done on-device. The selected district is stored on device in app storage, but the location is discarded.</p>

        <p>We do not use cookies in the app.</p>

        <p>On the website, we use cookies to authenticate logged-in users. We do not use cookies to collect or store
            personal information.</p>

    </div>

@endsection
