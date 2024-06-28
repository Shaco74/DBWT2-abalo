<!-- resources/views/articles/index.blade.php -->
@php
    use App\Helpers\ImageHelper;
@endphp
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Article View</title>
</head>
<body class="bg-black">
<div class="font-sans antialiased dark:bg-black dark:text-white/50 font p-4 flex flex-col h-screen">
    <!-- Custom Scripts -->
    @vite(['resources/js/app.js'])

    <!-- Styles -->
    @vite('resources/css/app.css')
    <div id="app" class="mb-4">
        @verbatim
            <x-cookie-dialog></x-cookie-dialog>
            <x-navigation></x-navigation>
        @endverbatim
        <div class="flex flex-grow justify-center">
                <div class="p-4">
                    @verbatim
                        <x-article-search></x-article-search>
                    @endverbatim
                </div>
        </div>
            <div class="sticky inset-x-0 bottom-0">
                @verbatim
                    <x-footer></x-footer>
                @endverbatim
            </div>
    </div>
</div>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

</body>
