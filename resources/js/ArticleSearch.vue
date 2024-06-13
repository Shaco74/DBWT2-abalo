<template>
    <div class="search-container">
        <input type="text" placeholder="Search..." v-model="searchQuery" @input="handleSearch" class="search-input">
        <div v-if="filteredResults.length" class="search-results">
            <table>
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Article Image</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="article in filteredResults" :key="article.ab_id">
                    <td>{{ article.id }}</td>
                    <td>{{ article.ab_name }}</td>
                    <td>{{ article.ab_description }}</td>
                    <td>
                        <img v-if="article.image" :src="article.image" alt="Article Image"/>
                        <span v-else>No Image Available</span>
                    </td>
                    <td>
                        <button v-if="!article.isInShoppingCart" @click="addToCart(article)"
                                class="w-full font-extrabold text-4xl">+
                        </button>
                        <span v-else>Already in cart</span>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            searchQuery: '',
            searchResults: [],
            filteredResults: []
        };
    },
    mounted() {
        // Make an HTTP GET request to fetch the items
        this.fetchItems();
    },
    methods: {
        fetchItems() {
            axios.get('/api/articles')
                .then(response => {
                    this.searchResults = response.data.articles;
                    this.filteredResults = this.searchResults.filter(article => article.isInShoppingCart === false);
                })
                .catch(error => {
                    console.error('Error fetching items:', error);
                });
        },
        handleSearch() {
            if (this.searchQuery.length >= 3) {
                this.filteredResults = this.searchResults.filter(article => {
                    return (
                        article.ab_name.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                        article.ab_description.toLowerCase().includes(this.searchQuery.toLowerCase())
                    );
                }).slice(0, 5); // Only take the first 5 results
            } else {
                // Display all items if search term is less than 3 characters
                this.filteredResults = this.searchResults.filter(article => article.isInShoppingCart === false);
            }
        },
        addToCart(article) {
            axios({
                method: 'post',
                url: '/api/shoppingcart',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                data: {
                    articleId: article.id,
                }
            })
                .then(response => {
                    if (response.data.error) {
                        swal('Fehler', 'Beim Hinzufügen des Artikels zum Warenkorb ist ein Fehler aufgetreten. Der Artikel ist wohlmöglich bereits im Warenkorb', 'error');
                    } else {
                        swal(`${article.ab_name} wurde zum Warenkorb hinzugefügt`, "", "success");
                        this.fetchItems();
                    }
                })
                .catch(error => {
                    console.error('Error adding article to cart:', error);
                });
        }
    }
};
</script>

<style lang="scss">
table {
    color: white;
}

.search-container {
    font-family: 'Arial', sans-serif;
    border: 2px solid #333;
    padding: 10px;
    border-radius: 5px;
    color: white;

    .search-input {
        width: 100%;
        padding: 8px;
        margin-bottom: 10px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 3px;
        color: black;
    }

    .search-results {
        color: white !important;

        ul {
            list-style: none;
            padding: 0;
            margin: 0;

            .search-result-item {
                padding: 8px;
                margin-bottom: 5px;
                background-color: #f2f2f2;
                border-radius: 3px;

                &:hover {
                    background-color: #e0e0e0;
                    cursor: pointer;
                }
            }
        }
    }
}
</style>
