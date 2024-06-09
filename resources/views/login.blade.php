@extends('layouts.app')

@section('title', 'Login')

@section('description', 'Log in to your account')

@section('main-class', 'flex items-center')

@section('content')

    <div class="container max-w-md mx-auto px-4 grid gap-4 -mt-8">

        @include('common.alerts')

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
