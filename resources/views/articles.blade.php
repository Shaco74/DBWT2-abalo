<!-- resources/views/articles/index.blade.php -->

@php
    use App\Helpers\ImageHelper;
@endphp
<div class="font-sans antialiased dark:bg-black dark:text-white/50 font">
<!-- Custom Scripts -->
@vite(['resources/js/app.js'])

<!-- Styles -->
@vite('resources/css/app.css')
<div id="app">
    @verbatim
        <x-navigation></x-navigation>
    @endverbatim
</div>
    <div class="flex">
<div class="basis-1/4"></div>
<div class="basis-1/2 justify-center">
<h1>Article Overview</h1>
<form action="{{ url('/articles') }}" method="get">
    <label for="search">Search:</label>
    <input type="text" id="search" name="search" value="{{ request()->input('search') }}">
    <button type="submit">Search</button>
</form>

    <div class="h-vh ">
<table style="border-collapse: collapse " class="text-red-100 bg-stone-600 ">
    <thead class="bg-stone-800 text-red-200">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Description</th>
        <th>Article Image</th>
    </tr>
    </thead>
    <tbody>
    @foreach($articles as $article)
        <tr style="border: 2px solid #9ca3af">
            <td>{{ $article->id }}</td>
            <td>{{ $article->ab_name }}</td>
            <td>{{ $article->description }}</td>
            <td>{!! ImageHelper::renderImageIfPresent($article->image) !!}</td>
            <td>
                <button @click="addToCart({{ $article->id }})">+</button>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
    </div>
</div>
<div class="basis-1/4">
    <div class="mb-4">
        <h2>Warenkorb</h2>
        <ul>
            <li v-for="item in cart">
                {{ item }}
            </li>
        </ul>
    </div>
</div>
</div>
</div>
