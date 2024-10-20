@extends('layouts.app')

@section('title', 'Login')

@section('description', 'Log in to your account')

@section('main-class', 'flex items-center')

@section('content')

    <div class="max-w-md mx-auto px-4 grid gap-4 -mt-8">

        @include('common.alerts')

        <form class="grid gap-4 bg-gray-200 dark:bg-gray-900 rounded shadow p-8" method="post">
            @csrf

            <h1 class="text-2xl font-bold">{{ __('Log in') }}</h1>

            <fieldset class="grid gap-4 mb-4">
                @include('common.input', [
                    'name' => 'email',
                    'label' => __('DCM/C, Area Chair, Delegate, or GSO email'),
                    'type' => 'email',
                    'required' => true,
                    'placeholder' => __('address@example.com'),
                ])
            </fieldset>

            @include('common.submit')

        </form>
    </div>

@endsection
