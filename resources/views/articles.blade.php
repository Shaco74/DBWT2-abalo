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
            <div class="h-vh">
                <table style="border-collapse: collapse " class="text-red-100 bg-stone-600 ">
                    <thead class="bg-stone-800 text-red-200">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Article Image</th>
                        <th>Action</th>
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
                                <button onclick="addToCart('{{ $article->ab_name }}')">+</button>
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
                <table class="cart-list">
                    <thead>
                    <tr>
                        <th>Artikel</th>
                        <th>Remove</th>
                    </tr>
                    </thead>
                    <tbody id="cart-body">
                    <!-- Hier wird der Warenkorbinhalt dynamisch eingefügt -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<script>
    window.cart = [];

    function addToCart(article) {
        if(window.cart.includes(article)) {
            return;
        }
        console.log('Add to cart');
        window.cart.push(article);
        updateCart();
    }

    function removeFromCart(article) {
        const index = window.cart.indexOf(article);
        if (index !== -1) {
            window.cart.splice(index, 1);
            updateCart();
        }
    }

    function updateCart() {
        // Holen Sie sich das Warenkorbtabelle Body-Element
        const cartBody = document.getElementById('cart-body');
        cartBody.innerHTML = '';

        // Fügen Sie jedes Element im Warenkorb erneut hinzu
        window.cart.forEach((article) => {
            // Erstellen Sie eine Zeile für den Artikel
            const row = document.createElement('tr');

            // Erstellen Sie eine Zelle für den Artikelnamen
            const nameCell = document.createElement('td');
            nameCell.textContent = article;
            nameCell.style.padding = '0.5rem';
            nameCell.style.border = '1px solid #9ca3af';
            nameCell.style.color = 'white';

            // Erstellen Sie eine Zelle für den Button zum Entfernen des Artikels
            const removeCell = document.createElement('td');
            const removeButton = document.createElement('button');
            removeButton.textContent = '-';
            removeButton.onclick = () => removeFromCart(article);
            removeButton.style.marginLeft = '1rem';
            removeCell.appendChild(removeButton);
            removeButton.style.color = 'white';
            removeCell.style.border = '1px solid #9ca3af';

            // Fügen Sie die Zellen zur Zeile hinzu
            row.appendChild(nameCell);
            row.appendChild(removeCell);

            // Fügen Sie die Zeile zum Warenkorb-Body hinzu
            cartBody.appendChild(row);
        });
    }
</script>
