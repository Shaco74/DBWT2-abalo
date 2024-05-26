<!-- resources/views/articles/index.blade.php -->
@php
    use App\Helpers\ImageHelper;
@endphp
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Article View</title>
</head>
<body class="bg-black overflow-hidden h-screen">

<div class="font-sans antialiased dark:bg-black dark:text-white/50 font p-4 flex flex-col h-full">
    <!-- Custom Scripts -->
    @vite(['resources/js/app.js'])

    <!-- Styles -->
    @vite('resources/css/app.css')
    <div id="app" class="mb-4">
        @verbatim
            <x-cookie-dialog></x-cookie-dialog>
            <x-navigation></x-navigation>
            <x-search></x-search>
        @endverbatim
    </div>
    <div class="flex flex-grow overflow-hidden">
        <div class="basis-1/4"></div>
        <div class="basis-1/2 flex flex-col overflow-hidden">
            <div class="p-4">
                <form action="{{ url('/articles') }}" method="get">
                    <input type="text" id="search" name="search" value="{{ request()->input('search') }}" class="peer bg-transparent text-blue-gray-700 font-sans font-normal outline" placeholder="Search">
                </form>
            </div>
            <div class="flex justify-center overflow-scroll h-96 overflow-x-hidden rounded">
                <table style="border-collapse: collapse" class="text-red-100 bg-stone-600 w-full rounded">
                    <thead class="bg-stone-800 text-red-200">
                    <tr>
                        <th class="pr-4">ID</th>
                        <th>Name</th>
                        <th>Article Image</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($articles as $article)
                        <tr style="border: 2px solid #9ca3af;">
                            <td class="pr-4">{{ $article->id }}</td>
                            <td>{{ $article->ab_name }}
                                <p>{{ $article->ab_description }}</p>
                            </td>
                            <td>{!! ImageHelper::renderImageIfPresent($article->image) !!}</td>
                            <td class="bg-stone-800">
                                <button onclick="addToCart({{ json_encode($article) }})" class="w-full">+</button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="basis-1/4">
            <div class="mb-4 pl-4">
                <h2>Warenkorb</h2>
                <div class="overflow-y-auto h-64">
                    <a class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded" href="/cart/show">Show Cart</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    // Funktion zum Hinzufügen eines Artikels zum Warenkorb
    const addToCart = (article) => {
        fetch('/cart/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                articleId: article.id,
                quantity: 1
            })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    swal(`${article.ab_name} wurde zum Warenkorb hinzugefügt`, "", "success");
                    updateCart();
                } else {
                    swal('Fehler', 'Beim Hinzufügen des Artikels zum Warenkorb ist ein Fehler aufgetreten.', 'error');
                }
            });
    };

    // Funktion zum Entfernen eines Artikels aus dem Warenkorb
    const removeFromCart = (articleId) => {
        fetch('/cart/remove', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                articleId: articleId
            })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    swal('Artikel wurde aus deinem Warenkorb entfernt', '', 'success');
                    updateCart();
                } else {
                    swal('Fehler', 'Beim Entfernen des Artikels aus dem Warenkorb ist ein Fehler aufgetreten.', 'error');
                }
            });
    };

    // Funktion zum Erstellen eines HTML-Elements für einen Warenkorbartikel
    const createCartItemElement = (article) => {
        return `
        <tr class="border border-gray-400">
            <td class="p-2 text-white">${article.ab_name}</td>
            <td class="text-white">
                <button class="m-4 text-white" onclick="removeFromCart(${article.id})">-</button>
            </td>
        </tr>
    `;
    };

    // Funktion zum Aktualisieren des Warenkorbs
    const updateCart = () => {
        fetch('/cart/show', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            }
        })
            .then(response => response.json())
            .then(data => {
                const cartBody = document.getElementById('cart-body');
                cartBody.innerHTML = '';

                data.articles.forEach((article) => {
                    cartBody.innerHTML += createCartItemElement(article);
                });
            });
    };

    // Bei Seitenaufruf den Warenkorb initialisieren
    document.addEventListener('DOMContentLoaded', function() {
        updateCart();
    });

</script>
<style>
    /* Benutzerdefinierte Scrollleistenstile */
    ::-webkit-scrollbar {
        width: 12px; /* Breite der Scrollleiste */
    }

    ::-webkit-scrollbar-track {
        background: transparent; /* Hintergrundfarbe der Scrollleiste */
    }

    ::-webkit-scrollbar-thumb {
        background-color: #4f4f4f; /* Farbe des Scrollbalkens */
        border-radius: 6px; /* Abrundungsradius */
        border: 3px solid transparent; /* Rand der Scrollbalken */
        background-clip: content-box; /* Hintergrundclip */
    }

    ::-webkit-scrollbar-thumb:hover {
        background-color: #333; /* Farbe des Scrollbalkens beim Hovern */
    }
</style>

</body>
