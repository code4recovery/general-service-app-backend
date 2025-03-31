<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="/favicon.png">

    <title>Area Map</title>

    @vite('resources/css/app.css')
</head>

<body>
    <div id="map" class="h-dvh"></div>

    @vite('resources/js/app.js')
</body>

</html>
