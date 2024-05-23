<template>
    <div class="flex justify-center p-10">
        <input type="text" v-model="search" @keyup.enter="searchArticles">
        <ul>
            <li v-for="article in articles" :key="article.id">
                {{ article.ab_name }}
            </li>
        </ul>
        <ul>
            <li v-for="error in errors" :key="error">
                {{ error }}
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    name: "SearchArticle",
    data() {
        return {
            search: '',
            articles: [],
            errors: []
        }
    },
    methods: {
        searchArticles() {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '/api/articles?search=' + this.search, true);

            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onreadystatechange = () => {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        this.articles.push('success', 'Daten erfolgreich abgerufen.')
                        this.articles = JSON.parse(xhr.responseText).articles;
                    } else if (xhr.readyState === 4 && xhr.status !== 200) {
                        this.errors.push('Fehler beim Abrufen der Daten.');
                    }
                }
            };
            xhr.send();
        }
    }
}
</script>

<style scoped>
input {
    width: 20%;
    color: #333;
}

ul {
    list-style-type: none;
}

li {
    padding: 10px;
    border: 1px solid #ccc;
    margin-top: 5px;
}
</style>
