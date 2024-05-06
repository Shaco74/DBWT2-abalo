<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Error</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com"></script>


    <!-- Custom Scripts -->
    @vite(['resources/js/app.js'])

    <!-- Styles -->
    @vite('resources/css/app.css')
    <style>

    </style>
</head>
<body class="font-sans antialiased dark:bg-black dark:text-white/50">
<header class="items-start gap-2 py-10 !bg-black flex flex-row w-full justify-start">

    <div id="app">
        @verbatim
            <x-navigation>
            </x-navigation>
            <x-error-message :message="'Ein Fehler ist aufgetaucht'" />
        @endverbatim
    </div>
    {{--    <x-error-message :message="$errorMessage" />--}}

</header>
<p>{{ $errorMessage }}</p>

</body>
</html>
