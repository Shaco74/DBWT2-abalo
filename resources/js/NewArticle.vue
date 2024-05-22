<template>
    <div>
        <p>
            <a id="btArticle" href="/articles">Zurück zur Artikelübersicht</a>
        </p>
        <p id="GFG_DOWN"></p>
        <div class="bg-stone-200 h-auto p-4 mx-auto my-4 rounded-md text-black">
            <form id="articleForm" @submit.prevent="sendArticle">
                <input type="hidden" name="_token" :value="csrfToken">

                <div class="form-group">
                    <label for="ab_name">Artikel Name</label>
                    <input type="text" v-model="article.ab_name" id="ab_name" placeholder="Namen des Artikels" required>
                </div>

                <div class="form-group">
                    <label for="ab_description">Artikel Beschreibung</label>
                    <textarea v-model="article.ab_description" id="ab_description" placeholder="Beschreibung des Artikels" rows="4" required></textarea>
                </div>

                <div class="form-group">
                    <label for="ab_price">Preis</label>
                    <input type="number" step="0.01" v-model="article.ab_price" id="ab_price" placeholder="Preis des Artikels" required>
                </div>

                <div class="form-group">
                    <label for="ab_creator_id">Ersteller-ID</label>
                    <input type="number" v-model="article.ab_creator_id" id="ab_creator_id" placeholder="ID des Erstellers">
                </div>

                <input type="submit" :disabled="isSubmitting" :class="{ 'disabled': isSubmitting }" value="Erstellen">
            </form>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';

const article = ref({
    ab_name: '',
    ab_description: '',
    ab_price: null,
    ab_creator_id: null,
});

const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const isSubmitting = ref(false);

/*
* P3: Task 2
* 3h
* */
const sendArticle = () => {
    if (isSubmitting.value) return;

    isSubmitting.value = true;
    const formData = new FormData();
    formData.append('ab_name', article.value.ab_name);
    formData.append('ab_description', article.value.ab_description);
    formData.append('ab_price', article.value.ab_price);
    formData.append('ab_creator_id', article.value.ab_creator_id);
    formData.append('_token', csrfToken);
    
    const xhr = new XMLHttpRequest();
    xhr.open('POST', '/articles/store', true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                document.getElementById('GFG_DOWN').innerHTML = 'Artikel erfolgreich erstellt!';
                document.getElementById('GFG_DOWN').style.color = 'green';
            } else {
                document.getElementById('GFG_DOWN').innerHTML = 'Artikel konnte nicht erstellt werden!';
                document.getElementById('GFG_DOWN').style.color = 'red';
            }
            setTimeout(() => {
                isSubmitting.value = false;
            }, 5000); // Button is disabled for 5 seconds
        }
    };
    xhr.send(formData);
};
</script>

<style scoped>
form {
    margin: 40px auto;
    width: 250px;
}

input[type='text'],
input[type='number'],
textarea {
    width: 100%;
    height: 30px;
    margin-top: 5px;
}

input,
textarea {
    text-indent: 10px;
    font-size: small;
    width: 100%;
}

input:focus,
textarea:focus {
    animation: fadeIn 1s;
}

input[type='submit'] {
    width: 100%;
    height: 35px;
    background-color: green;
    color: white;
    border: none;
}

input[type='submit']:hover {
    background-color: darkgreen;
}

input[type='submit'].disabled {
    background-color: grey;
    cursor: not-allowed;
}

textarea {
    width: 100%;
    margin-top: 5px;
}

label {
    font-weight: bold;
}

.form-group {
    margin-bottom: 10px;
}

p {
    text-align: center;
    margin-top: 20px;
}
</style>
