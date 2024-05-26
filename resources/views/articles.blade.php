<!-- resources/views/articles/index.blade.php -->
@php
    use App\Helpers\ImageHelper;
@endphp
<body class="bg-black overflow-hidden">


<div class="font-sans antialiased dark:bg-black dark:text-white/50 font p-4">
    <!-- Custom Scripts -->
    @vite(['resources/js/app.js'])

    <!-- Styles -->
    @vite('resources/css/app.css')
    <div id="app">
        @verbatim
            <x-cookie-dialog></x-cookie-dialog>
            <x-navigation></x-navigation>
            <x-search></x-search>
        @endverbatim
    </div>
    <div class="flex">
        <div class="basis-1/4"></div>
        <div class="basis-1/2">
            <div>

            <form action="{{ url('/articles') }}" method="get">
                <input type="text" id="search" name="search" value="{{ request()->input('search') }}" class="peer bg-transparent text-blue-gray-700 font-sans font-normal outline" placeholder="Search">
            </form>
            </div>
               <div class="flex justify-center overflow-scroll h-96 overflow-x-hidden mt-40">
                <table style="border-collapse: collapse " class="text-red-100 bg-stone-600">
                    <thead class="bg-stone-800 text-red-200">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Article Image</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($articles as $article)
                        <tr style="border: 2px solid #9ca3af;">
                            <td>{{ $article->id }}</td>
                            <td>{{ $article->ab_name }}
                                <p>{{ $article->ab_description }}</p>
                            </td>
                            <td>{!! ImageHelper::renderImageIfPresent($article->image) !!}</td>
                            <td class="bg-stone-800">
                                <button onclick="addToCart('{{ $article->ab_name }}')" class="w-full">+</button>
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
                <table class="cart-list text-red-50">
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

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    // Globale Warenkorb-Variable
    const cart = [];

    // Funktion zum Hinzufügen eines Artikels zum Warenkorb
    const addToCart = (article) => {
        console.log(article);
        if(cart.includes(article)) {
            swal(`${article} bereits im Warenkorb`, "Du kannst ein Produkt nur einmal zum Warenkorb hinzufügen", "error")
            return;
        }
        console.log('Add to cart');
        cart.push(article);
        updateCart();
    };

    // Funktion zum Entfernen eines Artikels aus dem Warenkorb
    const removeFromCart = (article) => {

        const index = cart.indexOf(article);

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
                    swal(`${article} wurde aus deinem Warenkorb entfernt`, {
                        icon: "success",
                    });
                } else {
                    swal(`${article} wurde nicht aus dem Warenkorb entfernt`);
                }
            });
    };

    // Funktion zum Erstellen eines HTML-Elements für einen Warenkorbartikel
    const createCartItemElement = (article) => {
        return `
            <tr>
                <td style="padding: 0.5rem; border: 1px solid #9ca3af; color: white;">${article}</td>
                <td style="border: 1px solid #9ca3af;">
                    <button onclick="removeFromCart('${article}')" style="margin: 1rem; color: white; ">-</button>
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
</body>
