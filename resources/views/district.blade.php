@extends('layouts.app')

@section('title', $district->name)

@section('description', 'View stories')

@section('content')

    <div class="container max-w-6xl mx-auto px-4 grid gap-4">

        <div class="flex items-center justify-between w-full">
            <h1 class="text-2xl font-bold">
                District {{ $district->number() }}: {{ $district->name }}
            </h1>
            @include('common.button', [
                'href' => route('create-story', [$district->area_id, $district->number]),
                'label' => 'Create',
            ])
        </div>

        @if ($district->stories->isEmpty())
            <p>No stories yet.</p>
        @else
            <table class="table-fixed">
                <thead>
                    <tr>
                        <th class="w-1/2 border-b border-gray-600 font-light p-3 text-left">Title</th>
                        <th class="w-1/6 border-b border-gray-600 font-light p-3 text-left">Type</th>
                        <th class="w-1/6 border-b border-gray-600 font-light p-3 text-right">Effective</th>
                        <th class="w-1/6 border-b border-gray-600 font-light p-3 text-right">Expires</th>
                    </tr>
                    @foreach ($district->stories as $story)
                        <tr>
                            <td class="border border-gray-600 p-3">
                                <a href="{{ route('edit-story', [$story->id]) }}"
                                    class="text-blue-500 dark:text-white underline">
                                    {{ $story->title }}
                                </a>
                            </td>
                            <td class="border border-gray-600 p-3">
                                {{ ucfirst($story->type) }}
                            </td>
                            <td class="border border-gray-600 p-3 text-right">
                                {{ $story->effective_at->format('M j') }}
                            </td>
                            <td class="border border-gray-600 p-3 text-right">
                                {{ $story->expire_at->format('M j') }}
                            </td>
                        </tr>
                    @endforeach
            </table>
        @endif

    </div>

@endsection
