<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="/favicon.png">

    <title>@yield('title')</title>
    <meta name="description" content="@yield('description')">

    @vite('resources/css/app.css')

    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/sort@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-gray-200 dark:bg-gray-700 dark:text-white min-h-screen flex flex-col gap-6">
    <header>
        <div class="container max-w-6xl mx-auto px-4 py-6">
            <div class="flex justify-between items-center flex-col sm:flex-row gap-8">
                <div class="flex gap-4 items-center">
                    <a href="{{ route('home') }}" class="text-2xl font-bold">
                        <svg fill="currentColor" stroke="currentColor" viewBox="0 0 888 888" class="h-20">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M444 868.5C678.445 868.5 868.5 678.445 868.5 444C868.5 209.555 678.445 19.5 444 19.5C209.555 19.5 19.5 209.555 19.5 444C19.5 678.445 209.555 868.5 444 868.5ZM444 888C689.214 888 888 689.214 888 444C888 198.786 689.214 0 444 0C198.786 0 0 198.786 0 444C0 689.214 198.786 888 444 888Z" />
                            <path d="M77.3451 232.665L810.766 232.665L444.055 867.826L77.3451 232.665Z"
                                fill-opacity="0.25" stroke-width="19" />
                            <path d="M196.657 437.278L692.055 437.278L444.356 866.305L196.657 437.278Z"
                                fill-opacity="0.25" stroke-width="19" />
                            <path d="M318.361 649.554L569.561 649.554L443.961 867.1L318.361 649.554Z"
                                fill-opacity="0.25" stroke-width="19" />
                        </svg>
                    </a>
                    <a href="/" class="text-2xl font-light">
                        <h1>{{ __('General Service App') }}</h1>
                    </a>
                </div>
                <div>
                    @auth
                        <div x-data="{ isOpen: false }" class="relative">
                            @include('common.button', [
                                'click' => 'isOpen = !isOpen',
                                'icon' => 'chevron-down',
                                'highlighted' => 'isOpen',
                            ])

                            <div x-show="isOpen" x-cloak x-transition:enter="transition ease-out duration-100 transform"
                                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75 transform"
                                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                                class="-ml-28 left-[50%] md:left-auto md:origin-top-right absolute md:right-0 mt-2 w-56 rounded-md shadow-lg">
                                <div class="rounded bg-white text-black shadow-xs">
                                    @foreach (auth()->user()->entities as $entity)
                                        <a href="{{ route('entities.stories.index', $entity) }}"
                                            class="flex p-3 border-b gap-2 align-center">
                                            @include ('common.icon', ['icon' => 'home'])
                                            {{ $entity->name() }}
                                        </a>
                                    @endforeach
                                    @if (auth()->user()->admin)
                                        <a href="{{ route('entities.index') }}"
                                            class="flex p-3 border-b gap-2 align-center">
                                            @include ('common.icon', ['icon' => 'cog'])
                                            {{ __('Entities') }}
                                        </a>
                                        <a href="{{ route('users.index') }}" class="flex p-3 border-b gap-2 align-center">
                                            @include ('common.icon', ['icon' => 'cog'])
                                            {{ __('Users') }}
                                        </a>
                                    @endif
                                    <a href="/logout" class="flex p-3 border-b gap-2 align-center">
                                        @include ('common.icon', ['icon' => 'x'])
                                        {{ __('Log Out') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endauth

                    @guest
                        @if (!Request::is('login'))
                            @include('common.button', ['href' => route('login'), 'label' => __('Log in')])
                        @endif
                    @endguest
                </div>
            </div>
        </div>
    </header>

    <main class="flex-grow @yield('main-class')">

        @yield('content')

    </main>

    <footer class="pb-8 text-center text-sm">
        <p>
            <a href="{{ route('privacy') }}" class="text-black/70 dark:text-white/70 hover:underline">
                {{ __('Privacy Policy') }}
            </a>
        </p>
    </footer>
</body>

</html>
