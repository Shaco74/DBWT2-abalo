<!-- resources/views/articles/index.blade.php -->
@php
    use App\Helpers\ImageHelper;
@endphp
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
                    <table class="cart-list text-red-50 w-full border border-gray-400">
                        <thead>
                        <tr>
                            <th>Artikel</th>
                            <th>Remove</th>
                        </tr>
                        </thead>
                        <tbody id="cart-body">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    // Globale Warenkorb-Variable
    const cart = [];

    // Funktion zum Hinzufügen eines Artikels zum Warenkorb
    const addToCart = (article) => {
        if(cart.some(item => item.id === article.id)) {
            swal(`${article.ab_name} bereits im Warenkorb`, "Du kannst ein Produkt nur einmal zum Warenkorb hinzufügen", "error");
            return;
        }
        console.log('Add to cart');
        cart.push(article);
        updateCart();
    };

    // Funktion zum Entfernen eines Artikels aus dem Warenkorb
    const removeFromCart = (articleId) => {
        const index = cart.findIndex(item => item.id === articleId);

        swal({
            title: "Artikel löschen",
            text: "Möchtest du den Artikel wirklich vom Warenkorb entfernen?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    if (index !== -1) {
                        cart.splice(index, 1);
                        updateCart();
                    }
                    swal(`Artikel wurde aus deinem Warenkorb entfernt`, {
                        icon: "success",
                    });
                } else {
                    swal(`Artikel wurde nicht aus dem Warenkorb entfernt`);
                }
            });
    };

    // Funktion zum Erstellen eines HTML-Elements für einen Warenkorbartikel
    const createCartItemElement = (article) => {
        return `
            <tr class="border border-gray-400">
                <td class="p-2 text-white">${article.ab_name}
                    <p>${article.ab_price}</p></td>
                <td class="text-white">
                    <button class="m-4 text-white" onclick="removeFromCart(${article.id})">-</button>
                </td>
            </tr>
        `;
    };

    // Funktion zum Aktualisieren des Warenkorbs
    const updateCart = () => {
        const cartBody = document.getElementById('cart-body');
        cartBody.innerHTML = '';

        cart.forEach((article) => {
            cartBody.innerHTML += createCartItemElement(article);
        });
    };

    // Globale Warenkorb-Variable an das Fensterobjekt anhängen
    window.cart = cart;
    window.addToCart = addToCart;
    window.removeFromCart = removeFromCart;
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
