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
    <header>
        @verbatim
        <x-cookie-dialog></x-cookie-dialog>
        <x-navigation></x-navigation>
        @endverbatim
    </header>
    <div class="flex justify-center p-8 w-full">
        <div class="row justify-center w-[50%]">
            <h1 class="text-2xl flex justify-center">Artikel erstellen</h1>

                @verbatim

                    <x-new-article></x-new-article>
                    <x-create-api></x-create-api>
                @endverbatim
            </div>
        </div>
    </div>
    <div class="absolute inset-x-0 bottom-0">
        @verbatim
            <x-footer></x-footer>
        @endverbatim
    </div>
</div>
</body>
</html>
