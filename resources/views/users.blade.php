@extends('layouts.app')

@section('title', __('Users'))

@section('content')

    <div class="container max-w-6xl mx-auto px-4 grid gap-8">

        @include('common.alerts')

        @include('common.heading', [
            'title' => __('Users'),
            'button' => [
                'href' => route('users.create'),
                'label' => __('Create User'),
            ],
        ])

        @include('common.table', [
            'columns' => [__('Name'), __('Admin'), __('Entities'), __('Last Seen')],
            'empty' => __('No users yet.'),
            'rows' => $users->map(function ($user) {
                return [
                    'href' => route('users.edit', $user),
                    'values' => [
                        $user->name,
                        $user->admin ? __('Yes') : __('No'),
                        $user->entities->count() === 1 ? $user->entities[0]->name() : $user->entities->count(),
                        $user->last_seen ? $user->last_seen->diffForHumans() : __('Never'),
                    ],
                ];
            }),
        ])

    </div>

@endsection
