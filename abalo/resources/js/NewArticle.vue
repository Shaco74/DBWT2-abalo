<template>
    <div class="mb-20">

        <div>
            <p>
                <a id="btArticle" href="/articles">Zurück zur Artikelübersicht</a>
            </p>
            <p id="GFG_DOWN" :style="{ color: messageColor }">{{ message }}</p>
            <div class="bg-stone-200 h-auto p-4 mx-auto my-4 rounded-md text-black">
                <form @submit.prevent="sendArticle" class="article-form">
                    <input class="article-form__input" type="hidden" name="_token" :value="csrfToken">

                    <div class="article-form__group form-group">
                        <label class="article-form__label" for="ab_name">Artikel Name</label>
                        <input class="article-form__input" type="text" v-model="article.ab_name" id="ab_name"
                               placeholder="Namen des Artikels" required>
                    </div>

                    <div class="article-form__group form-group">
                        <label class="article-form__label" for="ab_description">Artikel Beschreibung</label>
                        <textarea class="article-form__textarea" v-model="article.ab_description" id="ab_description"
                                  placeholder="Beschreibung des Artikels" rows="4" required></textarea>
                    </div>

                    <div class="article-form__group form-group">
                        <label class="article-form__label" for="ab_price">Preis</label>
                        <input class="article-form__input" type="number" step="0.01" v-model="article.ab_price"
                               id="ab_price" placeholder="Preis des Artikels" required>
                    </div>

                    <div class="article-form__group form-group">
                        <label class="article-form__label" for="ab_creator_id">Ersteller-ID</label>
                        <input class="article-form__input" type="number" v-model="article.ab_creator_id"
                               id="ab_creator_id" placeholder="ID des Erstellers">
                    </div>

                    <button class="article-form__submit" type="submit" :disabled="isSubmitting"
                            :class="{ 'disabled': isSubmitting }">Erstellen
                    </button>
                </form>
            </div>
        </div>
        <UsersArticleManagement/>
    </div>
</template>

<script setup>
import {ref} from 'vue';
import UsersArticleManagement from "./UsersArticleManagement.vue";

const article = ref({
    ab_name: '',
    ab_description: '',
    ab_price: null,
    ab_creator_id: null,
});

const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const isSubmitting = ref(false);
const message = ref('');
const messageColor = ref('');

const sendArticle = () => {
    if (isSubmitting.value) return;

    isSubmitting.value = true;
    const formData = new FormData();
    formData.append('ab_name', article.value.ab_name);
    formData.append('ab_description', article.value.ab_description);
    formData.append('ab_price', article.value.ab_price);
    formData.append('ab_creator_id', article.value.ab_creator_id);
    formData.append('_token', csrfToken);

    fetch('/api/articles/store', {
        method: 'POST',
        body: formData
    })
        .then(response => {
            if (response.ok) {
                message.value = 'Artikel erfolgreich erstellt!';
                messageColor.value = 'green';
            } else {
                message.value = 'Artikel konnte nicht erstellt werden!';
                messageColor.value = 'red';
            }
            isSubmitting.value = false;
            setTimeout(() => {
                message.value = '';
            }, 5000); // Button is disabled for 5 seconds
        });
};
</script>


<style lang="scss">
.article-form {
    margin: 40px auto;
    width: 250px;

    &__group {
        margin-bottom: 10px;
    }

    &__label {
        font-weight: bold;
    }

    &__input,
    &__textarea {
        width: 100%;
        padding: 8px;
        margin-top: 5px;
        border-radius: 3px;
        border: 1px solid #ccc;
    }

    &__submit {
        width: 100%;
        height: 35px;
        background-color: green;
        color: white;
        border: none;

        &:hover {
            background-color: darkgreen;
        }

        &.disabled {
            background-color: grey;
            cursor: not-allowed;
        }
    }
}
</style>
