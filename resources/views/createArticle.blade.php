<!-- resources/views/articles/create.blade.php -->
<!-- Custom Scripts -->
@vite(['resources/js/app.js'])

<!-- Styles -->
@vite('resources/css/app.css')

    <div class="font-sans antialiased dark:bg-black dark:text-white/50">
    <div class="flex justify-center p-8 w-full">
        <div class="row justify-center ">
            <h1 class="text-2xl flex justify-center">Create Article</h1>
                <div id="app">
                    @verbatim
                        <x-navigation></x-navigation>
                        <x-new-article/>
                    @endverbatim
                </div>
            </div>
        </div>
    </div>
