@extends('layouts.app')

@section('title', 'Login')

@section('description', 'Log in to your account')

@section('main-class', 'flex items-center')

@section('content')

    <div class="container max-w-md mx-auto px-4 grid gap-4 -mt-8">
        @if (session('error'))
            <div class="bg-red-200 dark:bg-red-700 border-l-6 border-red-900 px-4 py-2 rounded">
                {{ session('error') }}
            </div>
        @endif

        @include('common.errors')

        <form class="grid gap-4 bg-white dark:bg-gray-800 rounded-lg shadow p-8" method="post">
            @csrf

            <legend class="text-2xl font-bold">Log in</legend>

            <fieldset class="grid gap-4 mb-4">
                @include('common.input', [
                    'name' => 'email',
                    'label' => 'Email',
                    'type' => 'email',
                    'required' => true,
                ])

                @include('common.input', [
                    'name' => 'password',
                    'label' => 'Password',
                    'type' => 'password',
                    'required' => true,
                ])
            </fieldset>

            @include('common.submit')

        </form>
    </div>

@endsection
