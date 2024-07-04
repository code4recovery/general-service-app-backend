@extends('layouts.app')

@section('title', 'Login')

@section('description', 'Log in to your account')

@section('main-class', 'flex items-center')

@section('content')

    <div class="container max-w-md mx-auto px-4 grid gap-4 -mt-8">

        @include('common.alerts')

        <form class="grid gap-4 bg-white dark:bg-gray-800 rounded shadow p-8" method="post">
            @csrf

            <h1 class="text-2xl font-bold">Log in</h1>

            <p>Are you a District Chair registered with GSO in <a href="https://fc.aa.org/"
                    class="underline text-blue-600 dark:text-blue-400" target="_blank">Fellowship
                    Connection</a>?</p>

            <fieldset class="grid gap-4 mb-4">
                @include('common.input', [
                    'name' => 'email',
                    'label' => 'Email',
                    'type' => 'email',
                    'required' => true,
                    'placeholder' => 'address@email.com',
                ])
            </fieldset>

            @include('common.submit')

        </form>
    </div>

@endsection
