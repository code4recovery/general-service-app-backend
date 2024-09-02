@extends('layouts.app')

@section('title', isset($user) ? $user->name : 'Create User')

@section('content')

    <div class="container max-w-6xl mx-auto px-4 grid gap-8">

        @include('common.alerts')

        @include('common.heading', [
            'title' => isset($user) ? $user->name : __('Create User'),
            'breadcrumbs' => [
                route('users.index') => __('Users'),
            ],
        ])


        <form class="grid gap-10" method="post"
            action={{ isset($user) ? route('users.update', $user) : route('users.store') }}>

            @csrf

            @isset($user)
                @method('PUT')
            @endisset

            <fieldset class="grid gap-5">

                <div class="grid lg:grid-cols-4 gap-3 lg:gap-5 items-center">

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
                </div>

                <label class="flex items-center">
                    <input type="checkbox" name="admin" @if (old('admin', isset($user) && $user->admin ? 'on' : '') === 'on') checked @endif>
                    <span class="ml-2">{{ __('Admin') }}</span>
                </label>

                <div class="grid gap-1 w-full">
                    <label for="entities" class="block">
                        {{ __('Entities') }}
                    </label>
                    <div class="grid gap-2 sm:grid-cols-2 lg:grid-cols-4">
                        @foreach ($entities as $entity)
                            <label class="flex items-center">
                                <input type="checkbox" name="entities[]" value="{{ $entity->id }}"
                                    @if (isset($user) && $user->entities->contains($entity)) checked @endif>
                                <span class="ml-2">{{ $entity->name() }}</span>
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
