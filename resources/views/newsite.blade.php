<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com"></script>


    <!-- Custom Scripts -->
    @vite(['resources/js/app.js'])

    <!-- Styles -->
    @vite('resources/css/app.css')
</head>
<body class="font-sans antialiased dark:bg-black dark:text-white/50">
<div id="app" >
    <div class="pt-4 bg-zinc-950">
        <!-- P3:  Aufgabe 1-->
        @verbatim
            <x-message></x-message>
        @endverbatim
        <header class="items-center gap-2 py-5 flex flex-row-reverse w-full justify-around">
            @verbatim
                <x-cookie-dialog></x-cookie-dialog>
                <x-navigation></x-navigation>
            @endverbatim
        </header>
    </div>
    <div class="pb-10">
        @verbatim
            <x-body></x-body>
        @endverbatim
    </div>
    <div class="sticky inset-x-0 bottom-0">
        @verbatim
            <x-footer></x-footer>
        @endverbatim
    </div>
</div>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</body>
</html>
