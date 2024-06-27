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
        <div class="flex flex-grow ">
            <div class="basis-1/4"></div>
            <div class="basis-1/2 flex flex-col">
                <div class="p-4">
                    @verbatim
                        <x-article-search></x-article-search>
                    @endverbatim
                </div>
            </div>
            <div class="basis-1/4">
                <div class="mb-4 pl-4">
                    <div class="overflow-y-auto h-64">
                        <a class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded" href="/cart/show">Warenkorb
                            anzeigen</a>
                    </div>
                </div>
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
