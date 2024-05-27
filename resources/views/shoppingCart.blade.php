<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Shopping Cart</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-black text-white">
<div class="container mx-auto mt-10">
    <h1 class="text-3xl mb-4">Warenkorb</h1>
    <a href="http://127.0.0.1:8020/articles">Back to Articles</a>
    <table class="min-w-full bg-gray-800 rounded-lg">
        <thead>
        <tr>
            <th class="py-2 px-4 bg-gray-700">ID</th>
            <th class="py-2 px-4 bg-gray-700">Name</th>
            <th class="py-2 px-4 bg-gray-700">Description</th>
            <th class="py-2 px-4 bg-gray-700">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($articlesCart as $article)
            <tr class="border-b border-gray-600">
                <td class="py-2 px-4">{{ $article->id }}</td>
                <td class="py-2 px-4">{{ $article->ab_name }}</td>
                <td class="py-2 px-4">{{ $article->ab_description }}</td>
                <td class="py-2 px-4">
                    <form action="{{ url('/api/shoppingcart/remove') }}" method="POST">
                        @csrf
                        <input type="hidden" name="articleId" value="{{ $article->id }}">
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded">Remove</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
