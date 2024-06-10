@extends('layouts.app')

@section('title', 'General Service App')

@section('description', 'An app designed for A.A. General Service')

@section('content')

    <div class="container max-w-3xl mx-auto px-4 grid gap-4">

        @include('common.heading', [
            'title' => 'Privacy Policy',
        ])

        <p>Effective date: June 2, 2024</p>

        <p>The General Service App does not use third-party analytics software or track user behavior in-app.</p>

        <p>We gauge service usage by checking server access logs.</p>

    </div>

@endsection
