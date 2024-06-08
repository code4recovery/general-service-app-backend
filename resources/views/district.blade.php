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
                'href' => "/stories/$district->area_id/$district->number/create",
                'label' => 'Create',
            ])
        </div>

        @if ($district->stories->isEmpty())
            <p>No stories yet.</p>
        @else
            <table>
                <thead>
                    <tr>
                        <th class="w-1/4 p-3 border-b border-gray-600 text-left font-light">Title</th>
                        <th class="w-1/4 p-3 border-b border-gray-600 text-right font-light">Effective</th>
                        <th class="w-1/4 p-3 border-b border-gray-600 text-right font-light">Expires</th>
                    </tr>
                    @foreach ($district->stories as $story)
                        <tr>
                            <td class="w-1/4 p-3 border border-gray-600">
                                <a href="{{ route('edit-story', [$story->id]) }}"
                                    class="text-blue-500 dark:text-white underline">
                                    {{ $story->title }}
                                </a>
                            </td>
                            <td class="w-1/4 p-3 border border-gray-600 text-right">
                                {{ $story->effective_at->format('M j') }}
                            </td>
                            <td class="w-1/4 p-3 border border-gray-600 text-right">
                                {{ floor(abs($story->expire_at->diffInDays())) }} days from now
                            </td>
                        </tr>
                    @endforeach
            </table>
        @endif

    </div>

@endsection
