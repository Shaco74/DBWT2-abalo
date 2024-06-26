<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Artikel erstellen</title>
    <!-- Include JavaScript -->
    @vite('resources/js/app.js')

    <!-- Styles -->
    @vite('resources/css/app.css')
</head>
<body class="bg-black">
<div id="app">
    <div class="font-sans antialiased dark:bg-black dark:text-white/50">
        <div class="grid justify-center p-8 w-full">
                @verbatim
                    <x-impressum></x-impressum>
                @endverbatim

        </div>
    </div>
    <div class="sticky inset-x-0 bottom-0">
        @verbatim
            <x-footer></x-footer>
        @endverbatim
    </div>
</div>
</body>
</html>
