@extends('layouts.app')

@section('title', isset($user) ? $user->name : 'Create User')

@section('content')

    <div class="container max-w-6xl mx-auto px-4 grid gap-4">

        @include('common.alerts')

        <form class="grid gap-10" method="post"
            action={{ isset($user) ? route('users.update', $user) : route('users.store') }}>

            @csrf

            @isset($user)
                @method('PUT')
            @endisset

            <fieldset class="grid gap-5">
                @include('common.input', [
                    'label' => 'Name',
                    'name' => 'name',
                    'type' => 'text',
                    'value' => old('name', $user->name ?? ''),
                    'required' => true,
                ])

                @include('common.input', [
                    'label' => 'Email',
                    'name' => 'email',
                    'type' => 'email',
                    'value' => old('email', $user->email ?? ''),
                    'required' => true,
                ])

                @isset($user)
                @else
                    @include('common.input', [
                        'label' => 'Password',
                        'name' => 'password',
                        'type' => 'password',
                        'value' => old('password', ''),
                        'required' => true,
                    ])
                @endisset

                <label class="flex items-center">
                    <input type="checkbox" name="admin" @if (old('admin', isset($user) && $user->admin ? 'on' : '') === 'on') checked @endif>
                    <span class="ml-2">Admin</span>
                </label>

                <div class="grid gap-1 w-full">
                    <label for="districts" class="block">
                        Districts
                    </label>
                    <div class="grid gap-2">
                        @foreach ($districts as $district)
                            <label class="flex items-center">
                                <input type="checkbox" name="districts[]" value="{{ $district->id }}"
                                    @if (isset($user) && $user->districts->contains($district)) checked @endif>
                                <span class="ml-2">{{ $district->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

            </fieldset>

            @include('common.submit', [
                'cancel' => route('users.index'),
                'delete' => isset($user) ? route('delete-user', $user) : null,
            ])
        </form>


    </div>


@endsection
