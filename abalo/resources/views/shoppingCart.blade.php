<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Shopping Cart</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>
<body class="bg-black text-white">
<div id="app">
<div class="container mx-auto mt-10">
    @verbatim
        <x-navigation></x-navigation>
    @endverbatim
    <a href="http://127.0.0.1:8020/articles">Back to Articles</a>
    <table class="min-w-full bg-gray-800 rounded-lg">
        <thead>
        <tr>
            <th class="py-2 px-4 bg-gray-700">ID</th>
            <th class="py-2 px-4 bg-gray-700">Name</th>
            <th class="py-2 px-4 bg-gray-700">Description</th>
            <th class="py-2 px-4 bg-gray-700">Price</th>
            <th class="py-2 px-4 bg-gray-700">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($articlesCart as $article)
            <tr class="cart-item border-b border-gray-600 ">
                <td class="py-2 px-4">{{ $article->id }}</td>
                <td class="py-2 px-4">{{ $article->ab_name }}</td>
                <td class="py-2 px-4">{{ $article->ab_description }}</td>
                <td class="item-price py-2 px-4">{{ $article->ab_price }}</td>
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
    <button hidden="{{empty($articlesCart)}}" id="buy-button" class="my-3 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Buy all</button>
    <div>
        <h3>Total: <span id="cart-total"></span></h3>
        <h3 class="hidden"><span id="cart-items"></span> </h3>
        <h3>Average: <span id="average"></span> </h3>
    </div>
</div>
</div>

<script>
    document.getElementById('buy-button').addEventListener('click', function() {
        fetch('/api/shoppingcart/buy', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Purchase successful!');
                    window.location.reload();
                } else {
                    alert('An error occurred: ' + data.error);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });

    document.addEventListener('DOMContentLoaded', function() {
        calculateCartTotal();
    });

    document.addEventListener('DOMContentLoaded', function() {
        calculateAverage();
    });
</script>
</body>
</html>
