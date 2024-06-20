@extends('layouts.app')

@section('title', 'Entities')

@section('description', 'View all service entities.')

@section('content')

    <div class="container max-w-6xl mx-auto px-4 grid gap-8">

        @include('common.alerts')

        @include('common.heading', [
            'title' => 'Entites',
        ])

        <div class="overflow-x-auto">
            <table class="table-fixed min-w-full">
                <tbody>
                    @foreach ($entities as $entity)
                        <tr class="hover:bg-gray-300 dark:hover:bg-gray-600">
                            @if ($entity->area)
                                <td class="border border-gray-300 dark:border-gray-600 w-16 text-center">
                                    <a href="{{ route('entity', $entity->id) }}" class="p-3 block">
                                        {{ $entity->area() }}
                                    </a>
                                </td>
                            @endif
                            @if ($entity->district)
                                <td class="border border-gray-300 dark:border-gray-600 w-16 text-center">
                                    <a href="{{ route('entity', $entity->id) }}" class="p-3 block">
                                        {{ $entity->area() }}
                                    </a>
                                </td>
                            @endif
                            <td @empty($entity->district) @empty($entity->area) colspan="3" @else colspan="2" @endempty
                            @endempty class="border border-gray-300 dark:border-gray-600">
                            <a href="{{ route('entity', $entity->id) }}" class="p-3 block">
                                {{ $entity->name }}
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

@endsection
