@extends('layouts.app')

@section('title', 'Login')

@section('description', 'Log in to your account')

@section('main-class', 'flex items-center')

@section('content')

    <div class="container max-w-md mx-auto px-4 grid gap-4 -mt-8">
        @if (session('error'))
            <div class="bg-green-200 dark:bg-green-700 border-l-6 border-green-900 px-4 py-2 rounded">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->login->any())
            <div class="bg-red-200 dark:bg-red-700 border-l-6 border-red-900 px-4 py-2 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->login->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form class="grid gap-4 bg-white dark:bg-gray-800 rounded-lg shadow p-8" method="post">
            @csrf

            <legend class="text-2xl font-bold">Login</legend>

            <div>
                <label for="email" class="block">Email</label>
                <input type="email" name="email" id="email" class="w-full border p-2 rounded bg-white text-black"
                    value="{{ old('email') }}" required>
            </div>

            <div>
                <label for="password" class="block">Password</label>
                <input type="password" name="password" id="password" class="w-full border p-2 bg-white text-black rounded"
                    required>
            </div>

            <div>
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 py-2 px-6 rounded font-semibold text-white">Login</button>
            </div>

        </form>
    </div>

@endsection
