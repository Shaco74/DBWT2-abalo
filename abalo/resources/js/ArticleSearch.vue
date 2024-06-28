<template>
    <div class="search-container">
        <input type="text" placeholder="Search..." v-model="searchQuery" @input="handleSearch"
               class="search-container__input">
        <div class="pagination">
            <button @click="changePage(-1)" :disabled="currentPage === 0">Previous</button>
            <button @click="changePage(1)" :disabled="searchResults.length <= 4">Next</button>
        </div>
        <div v-if="searchResults.length" class="search-container__results search-results">
            <table class="search-results__table">
                <thead>
                <tr>
                    <th class="search-results__header">ID</th>
                    <th class="search-results__header">Name</th>
                    <th class="search-results__header">Description</th>
                    <th class="search-results__header">Article Image</th>
                    <th class="search-results__header">Action</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="article in searchResults" :key="article.ab_id" class="search-results__item">
                    <td>{{ article.id }}</td>
                    <td>{{ article.ab_name }}</td>
                    <td>{{ article.ab_description }}</td>
                    <td>
                        <img v-if="article.image" :src="article.image" alt="Article Image"
                             class="search-results__image"/>
                        <span v-else class="search-results__no-image">No Image Available</span>
                    </td>
                    <td>
                        <button v-if="!article.isInShoppingCart" @click="addToCart(article)"
                                class="search-results__button">
                            +
                        </button>
                        <span v-else class="search-results__in-cart">Already in cart</span>
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
            currentPage: 0,
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
            axios.get('/api/articles', {
                params: {
                    page: this.currentPage,
                }
            })
                .then(response => {
                    this.searchResults = response.data.articles;
                })
                .catch(error => {
                    console.error('Error fetching items:', error);
                });
        },
        handleSearch() {
            if (this.searchQuery.length >= 3) {
                this.currentPage = 0; // Reset the current page when a new search term is entered
                axios.get('/api/articles', {
                    params: {
                        search: this.searchQuery,
                        page: this.currentPage
                    }
                })
                    .then(response => {
                        this.searchResults = response.data.articles;
                    })
                    .catch(error => {
                        console.error('Error fetching items:', error);
                    });
            } else {
                this.fetchItems();
            }
        },
        changePage(offset) {
            this.currentPage += offset;
            this.fetchItems(); // Call the method to fetch items for the new page
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
                        swal('Fehler', 'Beim Hinzufügen des Artikels zum Warenkorb ist ein Fehler aufgetreten. Der Artikel ist wohl möglich bereits im Warenkorb', 'error');
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
.pagination {
    width: 100%;
    display: flex;
    justify-content: space-around;
    margin-bottom: 10px;

    button {
        padding: 5px 10px;
        border: none;
        background-color: #333;
        color: white;
        cursor: pointer;
        border-radius: 5px;
    }
    :hover {
        background-color: #1f2937;
        transform: scale(1.1);
        transition: transform 0.2s ease-in-out;
    }

    button:disabled {
        background-color: rgb(168, 156, 156);
        cursor: not-allowed;
    }
}

.search-container {
    font-family: 'Arial', sans-serif;
    border: 2px solid #333;
    padding: 10px;
    border-radius: 5px;
    color: white;

    &__input {
        width: 100%;
        padding: 8px;
        margin-bottom: 10px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 3px;
        color: black;
    }

    &__results {
        color: white !important;
    }
}

.search-results {
    &__table {
        width: 100%;
        border-collapse: collapse;
        color: white;

        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
    }

    &__header {
        background-color: #333;
        color: white;
    }

    &__item {
        &:hover {
            background-color: #1f2937;
        }
    }

    &__image {
        max-width: 100px;
    }

    &__no-image {
        color: red;
    }

    &__button {
        background-color: green;
        color: white;
        border: none;
        padding: 5px;
        cursor: pointer;

        &:hover {
            background-color: darkgreen;
        }
    }

    &__in-cart {
        color: gray;
    }
}

/* Scrollleistenstile */
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
