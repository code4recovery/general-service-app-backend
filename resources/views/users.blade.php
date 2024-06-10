@extends('layouts.app')

@section('title', 'Users')

@section('content')

    <div class="container max-w-6xl mx-auto px-4 grid gap-8">

        @include('common.alerts')

        @include('common.heading', [
            'title' => 'Users',
            'button' => [
                'href' => route('users.create'),
                'label' => 'Create',
            ],
        ])

        @include('common.table', [
            'rows' => $users->map(function ($user) {
                return [
                    'Name' => $user->name,
                    'Admin' => $user->admin ? 'Yes' : 'No',
                    'Districts' =>
                        $user->districts->count() === 1
                            ? $user->districts[0]->number() . ': ' . $user->districts[0]->name
                            : $user->districts->count() . ' districts',
                    'Last Seen' => $user->last_seen ? $user->last_seen->diffForHumans() : 'Never',
                    'href' => route('users.edit', [$user->id]),
                ];
            }),
            'empty' => 'No users yet.',
        ])

    </div>

@endsection
