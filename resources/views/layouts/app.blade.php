<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="/favicon.png">

    <title>@yield('title')</title>
    <meta name="description" content="@yield('description')">

    @vite('resources/css/app.css')

    @livewireStyles
    @livewireScripts

    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/sort@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-white dark:bg-gray-800 dark:text-white min-h-screen flex flex-col gap-6">
    <header>
        <div class="container max-w-6xl mx-auto px-4 py-6">
            <div class="flex justify-between items-center flex-col sm:flex-row gap-8">
                <div class="flex gap-4 items-center">
                    <a href="{{ route('home') }}" class="text-2xl font-bold" aria-hidden="true" tabindex="-1">
                        <svg class="size-20" viewBox="0 0 1024 1024" fill="none">
                            <rect width="1024" height="1024" rx="180" fill="#00437C" />
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M512 936.5C746.445 936.5 936.5 746.445 936.5 512C936.5 277.555 746.445 87.5 512 87.5C277.555 87.5 87.5 277.555 87.5 512C87.5 746.445 277.555 936.5 512 936.5ZM512 956C757.214 956 956 757.214 956 512C956 266.786 757.214 68 512 68C266.786 68 68 266.786 68 512C68 757.214 266.786 956 512 956Z"
                                fill="white" />
                            <path d="M145.345 300.665L878.766 300.665L512.055 935.826L145.345 300.665Z" fill="#0066CC"
                                stroke="white" stroke-width="19" />
                            <path d="M264.657 505.278L760.054 505.278L512.356 934.305L264.657 505.278Z" fill="#03692C"
                                stroke="white" stroke-width="19" />
                            <path d="M386.361 717.554L637.561 717.554L511.961 935.1L386.361 717.554Z" fill="#D1B000"
                                stroke="white" stroke-width="19" />
                        </svg>
                    </a>
                    <a href="/" class="text-2xl font-bold">
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
                                'aria_label' => 'Open navigation',
                            ])

                            <div x-show="isOpen" x-cloak x-transition:enter="transition ease-out duration-100 transform"
                                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75 transform"
                                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                                class="-ml-28 left-[50%] md:left-auto md:origin-top-right absolute md:right-0 mt-2 w-56 rounded-md shadow-lg">
                                <div class="rounded bg-white text-black shadow-xs overflow-hidden">
                                    @foreach (auth()->user()->entities as $entity)
                                        <a href="{{ route('entities.stories.index', $entity) }}"
                                            class="flex p-3 border-b gap-2 align-center hover:bg-black/5">
                                            @include ('common.icon', ['icon' => 'home'])
                                            {{ $entity->name() }}
                                        </a>
                                    @endforeach
                                    @if (auth()->user()->admin)
                                        <a href="{{ route('entities.index') }}"
                                            class="flex p-3 border-b gap-2 align-center hover:bg-black/5">
                                            @include ('common.icon', ['icon' => 'cog'])
                                            {{ __('Entities') }}
                                        </a>
                                        <a href="{{ route('users.index') }}"
                                            class="flex p-3 border-b gap-2 align-center hover:bg-black/5">
                                            @include ('common.icon', ['icon' => 'cog'])
                                            {{ __('Users') }}
                                        </a>
                                    @endif
                                    <a href="/logout" class="flex p-3 border-b gap-2 align-center hover:bg-black/5">
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

    <footer class="py-8 text-center text-sm">
        <p>
            <a href="{{ route('privacy') }}" class="text-black/70 dark:text-white/70 hover:underline">
                {{ __('Privacy Policy') }}
            </a>
        </p>
    </footer>
</body>

</html>
