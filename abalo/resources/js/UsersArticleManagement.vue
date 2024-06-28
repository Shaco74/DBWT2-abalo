<template>
    <div>
        <h1>User Articles</h1>
        <div>
            <div v-if="articles.length === 0">No articles found.</div>
            <table v-else class="articles-table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="article in articles" :key="article.id">
                    <td>{{ article.id }}</td>
                    <td>{{ article.ab_name }}</td>
                    <td>{{ article.ab_description }}</td>
                    <td>
                        <span v-if="article.ab_discount && (article.ab_discount - article.ab_price !== 0)">
                            <span style="text-decoration: line-through;">{{ article.ab_price }} €</span>
                            <span>{{ article.ab_discount }} €</span>
                        </span>
                        <span v-else>
                            {{ article.ab_price }} €
                        </span>
                    </td>
                    <td>
                        <img v-if="article.image" :src="article.image" alt="Article Image" class="article-image"/>
                        <span v-else>No Image Available</span>
                    </td>
                    <td class="center-content">
                        <v-btn density="compact" icon="mdi-sale" @click="openDiscountModal(article)"></v-btn>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <!-- Discount Modal -->
        <v-dialog v-model="discountDialog" max-width="500">
            <v-card>
                <v-card-title>Rabatt setzen?</v-card-title>
                <v-card-text>
                    Möchtest du einen Rabatt auf diese Dienstleistung setzen?
                    <v-form ref="discountForm" v-model="valid" @submit.prevent="submitDiscount">
                        <v-text-field
                            v-model="discountPrice"
                            :rules="[priceRule]"
                            label="Neuer Preis"
                            required
                        ></v-text-field>
                        <!-- Hidden input for article ID -->
                        <input type="hidden" v-model="selectedArticleId" />
                        <v-btn color="cyan" @click="resetPrice">Preis auf Originalwert zurücksetzten</v-btn>
                    </v-form>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn @click="closeDiscountModal">Cancel</v-btn>
                    <v-btn color="primary" @click="submitDiscount">Submit</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script setup>
import {ref, onMounted} from 'vue';
import axios from 'axios';
import {getLoginContext} from './util/getLoginContext.js';

const articles = ref([]);
const discountDialog = ref(false);
const selectedArticle = ref(null);
const selectedArticleId = ref(null); // New ref for article ID
const discountPrice = ref('');
const valid = ref(false);

const priceRule = value => !!value || 'Price is required';

onMounted(async () => {
    let loginContext = await getLoginContext();
    if (!loginContext.isLoggedIn) {
        return;
    }
    try {
        const response = await axios.get(`/api/user/${loginContext.userId}/articles`);
        articles.value = response.data;
    } catch (error) {
        console.error('Error fetching articles:', error);
    }
});

const openDiscountModal = (article) => {
    selectedArticle.value = article;
    selectedArticleId.value = article.id; // Set the article ID
    discountPrice.value = article.ab_price;
    discountDialog.value = true;
};

const closeDiscountModal = () => {
    discountDialog.value = false;
};

const resetPrice = () => {
    discountPrice.value = selectedArticle.value.ab_price;
};

const submitDiscount = async () => {
    if (valid.value) {
        try {
            await axios.post('api/articles/discount', {
                articleId: selectedArticleId.value, // Use the article ID
                newPrice: discountPrice.value
            })
            // Update the article price in the UI
            selectedArticle.value.ab_discount = discountPrice.value;
            closeDiscountModal();
        } catch (error) {
            console.error('Error submitting discount:', error);
        }
    }
};
</script>

<style scoped>
.center-content {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
}

.articles-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.articles-table th, .articles-table td {
    border: 1px solid #424242;
    padding: 8px;
    text-align: left;
}

.articles-table th {
    background-color: #818181;
    font-weight: bold;
}

.article-image {
    width: 50px;
    height: 50px;
}
</style>
