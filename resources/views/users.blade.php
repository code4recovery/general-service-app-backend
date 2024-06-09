@extends('layouts.app')

@section('title', 'Users')

@section('content')

    <div class="container max-w-6xl mx-auto px-4 grid gap-4">

        @include('common.alerts')

        <div class="flex items-center justify-between w-full">
            <h1 class="text-2xl font-bold">
                Users
            </h1>
            @include('common.button', [
                'href' => route('users.create'),
                'label' => 'Create',
            ])
        </div>

        <table class="table-fixed">
            <thead>
                <tr>
                    <th class="w-1/2 border-b border-gray-400 dark:border-gray-600 font-light p-3 text-left">
                        Title
                    </th>
                    <th class="w-1/6 border-b border-gray-400 dark:border-gray-600 font-light p-3 text-left">
                        Admin
                    </th>
                    <th class="w-1/6 border-b border-gray-400 dark:border-gray-600 font-light p-3 text-right">
                        Districts
                    </th>
                    <th class="w-1/6 border-b border-gray-400 dark:border-gray-600 font-light p-3 text-right">
                        Last Seen
                    </th>
                </tr>
                @foreach ($users as $user)
                    <tr>
                        <td class="border border-gray-400 dark:border-gray-600 p-3">
                            <a href="{{ route('users.edit', [$user->id]) }}" class="text-blue-500 dark:text-white underline">
                                {{ $user->name }}
                            </a>
                        </td>
                        <td class="border border-gray-400 dark:border-gray-600 p-3">
                            {{ $user->admin ? 'Yes' : 'No' }}
                        </td>
                        <td class="border border-gray-400 dark:border-gray-600 p-3 text-right">
                            {{ $user->districts->count() === 1 ? $user->districts[0]->number() . ': ' . $user->districts[0]->name : $user->districts->count() . ' districts' }}
                        </td>
                        <td class="border border-gray-400 dark:border-gray-600 p-3 text-right">
                            {{ $user->last_seen ? $user->last_seen->diffForHumans() : 'Never' }}
                        </td>
                    </tr>
                @endforeach
        </table>

    </div>


@endsection
