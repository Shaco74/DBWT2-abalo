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
                    <td>{{ article.ab_price }} €</td>
                    <td>
                        <img v-if="article.image" :src="article.image" alt="Article Image" class="article-image"/>
                        <span v-else>No Image Available</span>
                    </td>
                    <td>
                        <p>action</p>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script setup>
import {ref, onMounted} from 'vue';
import axios from 'axios';
import {getLoginContext} from './util/getLoginContext.js';

const articles = ref([]);

onMounted(async () => {
    let loginContext = await getLoginContext();
    if (!loginContext.isLoggedIn) {
        return;
    }
    try {
        const response = await axios.get(`/api/user/${loginContext.userId}/articles`);
        console.log('Response:', response);
        //iterate over the result and jsonparse append all to the articeles ref


        articles.value = response.data;
        console.log('Articles:', articles.value);
    } catch (error) {
        console.error('Error fetching articles:', error);
    }
})
;
</script>

<style scoped>
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

.add-to-cart-button {
    background-color: #4CAF50;
    color: white;
    border: none;
    padding: 5px 10px;
    cursor: pointer;
}

.add-to-cart-button:hover {
    background-color: #45a049;
}
</style>
