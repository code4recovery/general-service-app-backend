<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>General Service App</title>
    <meta name="description" content="An app designed for A.A. General Service">

    @vite('resources/css/app.css')
</head>

<body class="font-sans antialiased dark:bg-gray-700 dark:text-white">

    <main class="mt-10">
        <div class="container max-w-6xl mx-auto px-4 grid lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2">
                <h1 class="text-3xl font-bold">An App for A.A. General Service</h1>
                <p class="mt-4 text-2xl font-light">Carry the message to your groups.</p>
                <p class="mt-4">This app is currently in beta in Area 06 District 06 (San Francisco). Once it exits
                    beta, any District Committee Member (DCM) will be able to sign up and manage local news and
                    contacts.</p>
                <h2 class="mt-4">Feature Overview</h2>
                <ul class="list-disc pl-5">
                    <li>Free</li>
                    <li>Private</li>
                    <li>Dark mode</li>
                    <li>Native support for English, Spanish, and French</li>
                    <li>Available on Android and iOS</li>
                </ul>
            </div>
            <div class="">
                <img src="{{ asset('screenshot.png') }}" alt="Hero" class="h-auto max-w-full">
            </div>
        </div>
    </main>

    <footer class="py-16 text-center text-sm text-black dark:text-white/70">
        <p>Privacy Policy</p>
    </footer>
</body>

</html>
