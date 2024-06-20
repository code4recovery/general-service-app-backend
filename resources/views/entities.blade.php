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
                <thead>
                    <tr>
                        <th colspan="3" class="border-b border-gray-300 dark:border-gray-600 font-light p-3 text-left">
                            Entity Name
                        </th>
                    </tr>
                    <tr class="hover:bg-gray-300 dark:hover:bg-gray-600">
                        <td colspan="3" class="border border-gray-300 dark:border-gray-600">
                            <a href="{{ route('entity') }}" class="p-3 block">
                                General Service Office
                            </a>
                        </td>
                    </tr>

                    @foreach ($areas as $area)
                        <tr class="hover:bg-gray-300 dark:hover:bg-gray-600">
                            <td class="border border-gray-300 dark:border-gray-600 w-16 text-center">
                                <a href="{{ route('entity', $area->id) }}" class="p-3 block">
                                    {{ $area->number() }}
                                </a>
                            </td>
                            <td colspan="2" class="border border-gray-300 dark:border-gray-600">
                                <a href="{{ route('entity', $area->id) }}" class="p-3 block">
                                    {{ $area->name }}
                                </a>
                            </td>
                        </tr>
                        @foreach ($area->districts as $district)
                            <tr class="hover:bg-gray-300 dark:hover:bg-gray-600">
                                <td class="border border-gray-300 dark:border-gray-600 w-16 text-center">
                                </td>
                                <td class="border border-gray-300 dark:border-gray-600 w-16 text-center">
                                    <a href="{{ route('entity', $area->id) }}" class="p-3 block">
                                        {{ $district->number() }}
                                    </a>
                                </td>
                                <td class="border border-gray-300 dark:border-gray-600">
                                    <a href="{{ route('entity', [$area->id, $district->number]) }}" class="p-3 block">
                                        {{ $district->name }}
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
            </table>
        </div>

    </div>

@endsection
