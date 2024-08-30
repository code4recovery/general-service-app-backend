@extends('layouts.app')

@section('title', 'Users')

@section('content')

    <div class="container max-w-6xl mx-auto px-4 grid gap-8">

        @include('common.alerts')

        @include('common.heading', [
            'title' => 'Users',
            'button' => [
                'href' => route('users.create'),
                'label' => 'Create User',
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
                        $user->admin ? 'Yes' : 'No',
                        $user->entities->count() === 1
                            ? $user->entities[0]->name()
                            : $user->entities->count() . ' entities',
                        $user->last_seen ? $user->last_seen->diffForHumans() : 'Never',
                    ],
                ];
            }),
        ])

    </div>

@endsection
