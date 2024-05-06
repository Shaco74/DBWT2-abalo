<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- Include the CSRF token -->
    <title>Artikel erstellen</title>
    <!-- Include JavaScript -->
    @vite('resources/js/app.js')

    <!-- Styles -->
    @vite('resources/css/app.css')
</head>
<body>

<div class="font-sans antialiased dark:bg-black dark:text-white/50">
    <div class="flex justify-center p-8 w-full">
        <div class="row justify-center ">
            <h1 class="text-2xl flex justify-center">Artikel erstellen</h1>
            <div id="app">
                @verbatim
                    <x-cookie-dialog></x-cookie-dialog>
                    <x-navigation></x-navigation>
                    <x-new-article></x-new-article>
                @endverbatim
            </div>
        </div>
    </div>
</div>
</body>
</html>
