@extends('layouts.app')

@section('title', 'General Service App')

@section('description', 'An app designed for A.A. General Service')

@section('content')

    <div class="container max-w-3xl mx-auto px-4 grid gap-4">

        @include('common.heading', [
            'title' => 'Onboarding',
        ])

        <p>Areas are onboarding one at a time. If you are an Area or District Chair, please contact your Area Delegate to
            express your interest and inquire when your Area will be onboarded.</p>

    </div>

@endsection
