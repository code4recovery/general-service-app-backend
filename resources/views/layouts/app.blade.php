<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

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
                        <svg fill="currentColor" viewBox="0 0.02 431.99 431.99" class="h-20">
                            <path
                                d="M2034.04 5139.98v524.2c-.22 22.64.66 56.03-13.12 87.79-6.94 15.8-18.42 31.35-35.51 42.2-17.06 10.91-38.75 16.65-64.26 16.61-25.62.04-47.4-5.85-64.46-16.99-25.82-16.8-37.83-43.07-43.16-66.61-5.44-23.79-5.23-46.77-5.28-63v-549.22h225.79v25.02"
                                transform="matrix(.13333 0 0 -.13333 0 920.64)" />
                            <path
                                d="m2300.19 5676.66-651.11 1127.76c408.32-7.67 776.87-176.04 1045.72-444.83 275.16-275.22 445.18-654.9 445.2-1074.79 0-266.7-68.7-517.12-189.24-734.92zm-491.94-646.35v-425.8h-94v425.8h-57.34v84.67l57.34-.02v549.22c.23 94.78 30.26 152.9 70.12 189.35 39.95 36.38 92.36 51.26 138.66 51.26 32.62.19 111.8-7.71 157.57-68.44 47.88-67.76 47.14-115.7 47.46-172.17V4604.49h-94.02v425.82zm886.55-820.32c-275.22-275.14-654.9-445.16-1074.79-445.18-419.89.02-799.572 170.04-1074.811 445.18-86.492 86.52-162.578 183.38-226.277 288.55H2921.09c-63.7-105.17-139.79-202.03-226.29-288.55zm-1491.56 820.32v-425.8h-94v425.8h-57.35v84.67l57.35-.02v549.22c.25 94.78 30.28 152.9 70.12 189.35 39.95 36.38 92.35 51.26 138.66 51.26 32.64.19 111.8-7.71 157.57-68.44 47.91-67.77 47.13-115.7 47.48-172.17V4604.49h-94.02v425.82zM100.02 5284.8c.019 419.89 170.039 799.57 445.179 1074.79 268.867 268.79 637.421 437.16 1045.751 444.83L939.828 5676.66l-650.551-1126.8c-120.562 217.8-189.242 468.23-189.257 734.94Zm1519.99 1619.99C725.293 6904.77.043 6179.52 0 5284.8c.043-894.74 725.293-1619.97 1620.01-1620.01 894.71.04 1619.97 725.27 1620 1620.01-.03 894.72-725.29 1619.97-1620 1619.99"
                                transform="matrix(.13333 0 0 -.13333 0 920.64)" />
                            <path
                                d="M1429.05 5139.98v524.2c-.21 22.64.63 56.03-13.14 87.79-6.94 15.8-18.4 31.35-35.49 42.2-17.08 10.91-38.75 16.65-64.27 16.61-25.61.04-47.4-5.85-64.45-16.99-25.83-16.8-37.85-43.07-43.18-66.61-5.44-23.79-5.24-46.77-5.28-63v-549.22h225.81v25.02M724.824 5520.91l-109.172 63.07-20.656-35.77 110.567-63.87c20.339-11.75 26.355-28.32 12.445-52.4-9.453-16.36-27.57-23.98-50.945-10.47l-108.938 62.93-20.66-35.77 111.273-64.28c17.102-9.26 32.684-13.58 48.235-10.41 25.246 5.38 42.215 26.12 51.129 41.55 24.441 42.32 20.902 79.91-23.278 105.42M697.91 5726.46l116.887-67.52-.277-.46-155.364.89-21.34-36.93 167.844-96.96 18.906 32.73-119.687 69.14.266.47 159.257-.66 20.254 35.07-167.84 96.96-18.906-32.73M738.105 5796.15l167.84-96.97 20.254 35.07-167.84 96.96-20.254-35.06M831.246 5888.87l138.156-79.8 20.254 35.06-138.152 79.81 29.301 50.72-29.688 17.15-78.859-136.51 29.683-17.15 29.305 50.72M1059.48 5965.09l20.26 35.06-62.88 36.33-72.559 116.74-22.953-39.75 53.757-75.32-93.054 7.3-23.903-41.37 137.981-2.4 63.351-36.59M2202.2 6042c30.16 17.42 28.34 42.18 21.78 66.51l-11.69 43.46c-2.09 7.4-5 18.91 8.1 26.47 15.19 8.78 28.54-3.01 35.62-15.27 16.27-28.19 0-41.04-6.99-46.21l17.89-30.99c20.45 12.1 46.78 44.24 19.45 91.57-28.93 50.13-67.24 40.35-85.94 29.55-36.93-21.34-29.1-48.95-21.01-77.55l5.36-19c5.23-18.79 8.43-32.43-4.66-39.99-17.76-10.26-31.54 4.43-40.37 19.71-16.27 28.19-.99 42.75 8.24 48.37l-17.89 30.98c-20.8-12.02-50.51-42.09-17.97-98.46 7.83-13.56 39.59-58.32 90.08-29.15M2210.05 5980.37l43.48 25.11 43.48-75.3 29.68 17.15-43.47 75.3 35.3 20.39 47.31-81.96 29.69 17.15-65.56 113.59-167.86-96.95 67.7-117.26 29.69 17.15-49.44 85.63M2398.36 5906.34l23.24-40.23c10.92-18.94-.06-30.16-8.94-35.28-16.59-9.59-27.63-5.06-37.31 11.71l-21.87 37.87zm-48.56-149.13c31.32 18.1 32.48 27.95 31.23 44.16 14.43-12.04 35.29-11.46 53.77-.79 14.49 8.37 43.11 34.94 19.37 76.04l-45.07 78.09-167.85-96.95 18.26-31.63 65.68 37.95 19.26-33.35c13.79-23.89 5.64-30.31-17.27-43.54-17.28-10-25.19-16.28-31.89-23.03l20.6-35.71 4.46 2.57c-1.18 8.51 4.9 12.01 29.45 26.19M2540.48 5727.12l-146.54-39.89-.25.43 108.04 106.59-20 34.64-137.78-149.02 17.76-30.77 198.15 44.46-19.38 33.56M2566.42 5682.22l-167.85-96.96 18.63-32.28 167.85 96.97-18.63 32.27M2564 5431.55l-18.63 32.27c-22.81-8-41-1.87-51.31 15.98-15.76 27.32 5.02 53.96 35.17 71.39 47.44 27.41 71.84 11.08 80.78-4.41 15.4-26.68-.68-42.57-9.23-50.95l18.63-32.27c23.78 16.03 47.58 54.74 20.86 101-22.97 39.79-70.9 53.71-129.57 19.81-57.99-33.49-71.12-80.38-47.4-121.47 22.36-38.74 60.5-45.96 100.7-31.35M2516.87 5380.38l67.7-117.26 29.68 17.15-49.43 85.62 43.48 25.12 43.47-75.3 29.69 17.15-43.48 75.3 35.31 20.39 47.31-81.96 29.69 17.15-65.57 113.59-167.85-96.95M983.293 4369.67h-47.508v51.83h50.477c23.748 0 28.338-15.12 28.338-25.38 0-19.16-10.25-26.45-31.307-26.45zm66.397-64.78c0 36.17-8.64 42.11-24.56 49.12 19.17 6.48 29.96 24.83 29.96 46.16 0 16.74-9.45 54.8-61.004 54.8h-97.981v-193.81h39.68v75.85h41.836c29.969 0 31.579-10.26 31.579-36.71 0-19.98 1.63-29.96 4.33-39.14h44.8v5.12c-8.64 3.25-8.64 10.27-8.64 38.61M1130.86 4345.65h94.48v34.28h-94.48v40.76h102.85v34.28h-142.53v-193.81h147.12v34.27h-107.44v50.22M1351.92 4425c33.48 0 39.69-21.86 42.92-33.47h40.49c-2.16 28.61-25.64 68.56-83.67 68.56-49.94 0-89.08-34.55-89.08-102.3 0-66.95 36.98-101.76 88.54-101.76 48.58 0 76.12 29.42 84.21 71.53h-40.49c-4.85-23.76-20.51-36.44-42.92-36.44-34.27 0-48.04 31.31-48.04 66.13 0 54.8 28.61 67.75 48.04 67.75M1550.49 4290.31c-21.86 0-52.63 13.49-52.63 67.75s30.77 67.76 52.63 67.76c21.86 0 52.64-13.5 52.64-67.76 0-54.26-30.78-67.75-52.64-67.75zm0 169.78c-25.64 0-93.13-11.06-93.13-102.03s67.49-102.03 93.13-102.03 93.12 11.06 93.12 102.03-67.48 102.03-93.12 102.03M1751.45 4261.16l65.86 193.81h-42.11l-42.1-146.85h-.55l-41.56 146.85h-43.47l65.33-193.81h38.6M1990.04 4295.43h-107.43v50.22h94.47v34.28h-94.47v40.76h102.84v34.28h-142.53v-193.81h147.12v34.27M2062.68 4421.5h50.48c23.75 0 28.34-15.12 28.34-25.38 0-19.16-10.25-26.45-31.31-26.45h-47.51zm0-84.49h41.84c29.97 0 31.58-10.26 31.58-36.71 0-19.98 1.62-29.96 4.32-39.14h44.81v5.12c-8.64 3.25-8.64 10.27-8.64 38.61 0 36.17-8.65 42.11-24.56 49.12 19.16 6.48 29.96 24.83 29.96 46.16 0 16.74-9.46 54.8-61.01 54.8H2023v-193.81h39.68v75.85M2254.86 4261.16h40.49v72.6l64.78 121.21h-45.88l-38.34-84.22-40.21 84.22h-47.78l66.94-120.66v-73.15"
                                transform="matrix(.13333 0 0 -.13333 0 920.64)" />
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
                                'icon' => 'caret-down',
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
                                            {{ __('Service Entities') }}
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
