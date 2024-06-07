@extends('layouts.app')

@section('title', $district->name)

@section('description', 'View stories')

@section('content')

    <div class="container max-w-6xl mx-auto px-4 grid gap-4">

        @include('common.errors')

        <form method="post" class="grid gap-8" action="/stories/{{ $district->area_id }}/{{ $district->number }}">
            @csrf

            <div class="grid gap-1">
                <label for="title" class="block">Title</label>
                <div class="grid lg:grid-cols-2 lg:gap-8">
                    <input type="text" name="title" id="title" value="{{ old('title') }}"
                        class="w-full p-2 border border-gray-300 rounded text-black" required>
                    <div>This is the headline of your story.</div>
                </div>
            </div>

            <div class="grid gap-1">
                <label for="description" class="block">Description</label>
                <div class="grid lg:grid-cols-2 lg:gap-8">
                    <textarea rows="3" type="text" name="description" id="description"
                        class="w-full p-2 border border-gray-300 rounded text-black" required>{{ old('description') }}</textarea>
                    <div>This is the content of your story. This is plain text only because apps have trouble displaying
                        rich text.</div>
                </div>
            </div>

            <div class="grid gap-1">
                <label for="effective_at" class="block">Effective Date</label>
                <div class="grid lg:grid-cols-2 lg:gap-8">
                    <input type="date"" type="text" name="effective_at" id="effective_at"
                        class="w-full p-2 border border-gray-300 rounded text-black"
                        value="{{ old('effective_at', $now->format('Y-m-d')) }}" required />
                    <div>The story will be displayed starting on this date.</div>
                </div>
            </div>

            <div class="grid gap-1">
                <label for="expire_at" class="block">Expire Date</label>
                <div class="grid lg:grid-cols-2 lg:gap-8">
                    <input type="date"" type="text" name="expire_at" id="expire_at"
                        class="w-full p-2 border border-gray-300 rounded text-black"
                        value="{{ old('expire_at', $now->add(2, 'months')->format('Y-m-d')) }}" required />
                    <div>This is the last day your story will be displayed. Must be after the effective date.</div>
                </div>
            </div>

            @foreach (['1', '2', '3'] as $button)
                <div class="grid gap-1">
                    <label for="buttons[{{ $button }}][link]" class="block">Button {{ $button }}
                        (Optional)
                    </label>
                    <div class="grid lg:grid-cols-2 lg:gap-8">
                        <div class="flex flex-col lg:flex-row gap-5">
                            <input type="url" type="text" name="buttons[{{ $button }}][link]"
                                id="buttons[{{ $button }}][link]" value="{{ old("buttons.$button.link") }}"
                                class="w-full p-2 border border-gray-300 rounded text-black"
                                placeholder="https://intergroup.org/img/flyer-234.pdf" />
                            <input type="text" type="text" name="buttons[{{ $button }}][title]"
                                id="buttons[{{ $button }}][title]" value="{{ old("buttons.$button.title") }}"
                                class="w-full p-2 border border-gray-300 rounded text-black"
                                placeholder="View Flyer"></textarea>
                        </div>
                        <div>
                            An optional "call-to-action" button to go below your story. To be valid, a button must have
                            both a URL and label text.
                        </div>
                    </div>
                </div>
            @endforeach

            <div>
                <input type="submit" value="Create Story"
                    class="bg-blue-600 hover:bg-blue-700 py-2 px-6 rounded font-semibold text-white">
            </div>


        </form>

    </div>

@endsection
