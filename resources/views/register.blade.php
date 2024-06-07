@extends('layouts.app')

@section('title', 'Register')

@section('description', 'District Committee Members log in here.')

@section('content')

    <div class="container max-w-3xl mx-auto px-4 grid gap-4">

        <h1 class="text-2xl font-bold">Register</h1>

        <p>Are you a District Chair? In some places this is called a DCMC (District Committee Member Chairperson) and in
            others it's a DCM (District Committee Member).</p>

        @if (session('success'))
            <div class="bg-green-200 dark:bg-green-700 border-l-6 border-green-900 px-4 py-2 rounded">
                {{ session('success') }}
            </div>
        @else
            @include('common.errors')
            <form class="grid gap-12 mt-5" method="post" x-data="{ timezone: Intl.DateTimeFormat().resolvedOptions().timeZone }">
                @csrf
                <input type="hidden" name="timezone" :value="timezone">
                <fieldset class="grid gap-5 border-t pt-4 border-gray-500">
                    <legend class="px-2 mx-4">About You</legend>
                    <p class="text-sm">
                        This information is kept private and is only used by us to contact you about your account.
                    </p>
                    <div class="flex gap-5 w-full">
                        <div class="grid gap-1 w-full">
                            <label for="name" class="block">Your Name</label>
                            <input type="text" name="name" id="name" required value="{{ old('name') }}"
                                class="w-full p-2 border border-gray-300 rounded text-black">
                        </div>

                        <div class="grid gap-1 w-full">
                            <label for="email" class="block">Email Address</label>
                            <input type="email" name="email" id="email" placeholder="email@district.org" required
                                value="{{ old('email') }}" class="w-full p-2 border border-gray-300 rounded text-black">
                        </div>
                    </div>
                    <div class="flex gap-5 w-full">
                        <div class="grid gap-1 w-full">
                            <label for="password" class="block">Password</label>
                            <input type="password" name="password" id="password" required value="{{ old('password') }}"
                                class="w-full p-2 border border-gray-300 rounded text-black">
                        </div>
                        <div class="grid gap-1 w-full">
                            <label for="password_confirmation" class="block">Password Confirmation</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" required
                                value="{{ old('password_confirmation') }}"
                                class="w-full p-2 border border-gray-300 rounded text-black">
                        </div>
                    </div>
                </fieldset>

                <fieldset class="grid gap-5 border-t pt-4 border-gray-500">
                    <legend class="px-2 mx-4">About Your District</legend>
                    <p class="text-sm">
                        This information will be displayed publicly when your request is approved.
                    </p>
                    <div class="flex gap-5 w-full">
                        <div class="grid gap-1 w-full">
                            <label for="area" class="block">Area</label>
                            <select name="area" id="area" required
                                class="w-full p-2 border border-gray-300 rounded appearance-none text-black">
                                @foreach ($areas as $area)
                                    <option value="{{ $area->id }}" {{ old('area') == $area->id ? 'selected' : '' }}>
                                        {{ $area->number() }}:
                                        {{ $area->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="grid gap-1 w-full">
                            <label for="district" class="block">District</label>
                            <input type="number" name="district" id="district" required value="{{ old('district') }}"
                                class="w-full p-2 border border-gray-300 rounded text-black" min="1">
                        </div>
                    </div>
                    <div class="flex gap-5 w-full">
                        <div class="grid gap-1 w-full">
                            <label for="location" class="block">District Location</label>
                            <input type="text" name="location" id="location" placeholder="San Francisco" required
                                value="{{ old('location') }}" class="w-full p-2 border border-gray-300 rounded text-black">
                        </div>
                        <div class="grid gap-1 w-full">
                            <label for="website" class="block">District Website (optional)</label>
                            <input type="url" name="website" id="website" placeholder="https://district.org"
                                value="{{ old('website') }}" class="w-full p-2 border border-gray-300 rounded text-black">
                        </div>
                    </div>
                </fieldset>

                <div>
                    <input type="submit" value="Register"
                        class="bg-blue-600 hover:bg-blue-700 py-2 px-6 rounded font-semibold text-white">
                </div>
            </form>
        @endif

    </div>

@endsection
