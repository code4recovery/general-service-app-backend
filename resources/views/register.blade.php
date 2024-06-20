@extends('layouts.app')

@section('title', 'Register')

@section('description', 'District Committee Members log in here.')

@section('content')

    <div class="container max-w-3xl mx-auto px-4 grid gap-4">

        @include('common.heading', [
            'title' => 'Register',
        ])

        <p>Are you a District Chair? In some places this is called a DCMC (District Committee Member Chairperson) and in
            others it's a DCM (District Committee Member).</p>

        @include('common.alerts')

        @if (!session('success'))
            <form class="grid gap-12 mt-5" method="post" x-data="{ timezone: Intl.DateTimeFormat().resolvedOptions().timeZone, language: navigator.language.substr(0, 2) }">
                @csrf
                <input type="hidden" name="timezone" :value="timezone">
                <input type="hidden" name="language" :value="language">
                <fieldset class="grid gap-5 border-t pt-4 border-gray-500 whitespace-nowrap">
                    <legend class="px-2 mx-4">About You</legend>
                    <p class="text-sm">
                        Personal information is kept confidential and only used to contact you about your account.
                    </p>
                    <div class="flex gap-5">
                        @include('common.input', [
                            'name' => 'name',
                            'label' => 'Your Name',
                            'type' => 'text',
                            'required' => true,
                        ])
                        @include('common.input', [
                            'name' => 'email',
                            'label' => 'Email',
                            'type' => 'email',
                            'placeholder' => 'chair@district.org',
                            'required' => true,
                        ])
                    </div>
                    <div class="flex gap-5">
                        @include('common.input', [
                            'name' => 'password',
                            'label' => 'Password',
                            'type' => 'password',
                            'required' => true,
                        ])
                        @include('common.input', [
                            'name' => 'password_confirmation',
                            'label' => 'Password Confirmation',
                            'type' => 'password',
                            'required' => true,
                        ])
                    </div>
                </fieldset>

                <fieldset class="grid gap-5 border-t pt-4 border-gray-500">
                    <legend class="px-2 mx-4 whitespace-nowrap">About Your District</legend>
                    <p class="text-sm">
                        District information is displayed on the website and in the app.
                    </p>
                    <div class="flex gap-5">
                        <div class="grid gap-1 w-full">
                            <label for="area" class="block">Area</label>
                            <select name="area" id="area" required
                                class="w-full p-2 border border-gray-300 rounded appearance-none text-black">
                                @foreach ($areas as $area)
                                    <option value="{{ $area->area }}" {{ old('area') == $area->id ? 'selected' : '' }}>
                                        {{ $area->name() }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @include('common.input', [
                            'name' => 'district',
                            'label' => 'District',
                            'type' => 'number',
                            'min' => '1',
                            'required' => true,
                        ])
                    </div>
                    <div class="flex gap-5">
                        @include('common.input', [
                            'name' => 'location',
                            'label' => 'District Location',
                            'type' => 'text',
                            'placeholder' => 'San Francisco',
                            'required' => true,
                        ])
                        @include('common.input', [
                            'name' => 'website',
                            'label' => 'District Website',
                            'type' => 'url',
                            'placeholder' => 'https://district.org',
                        ])
                    </div>
                </fieldset>

                @include('common.submit')
            </form>
        @endif

    </div>

@endsection
