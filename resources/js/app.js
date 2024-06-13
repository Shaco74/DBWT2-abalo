import { createApp } from 'vue';
import Navigation from './Navigation.vue';
import NewArticle from "./NewArticle.vue";
import CookieDialog from './util/CookieDialog.vue'
import CookieDisagree from "./CookieDisagree.vue";
import ErrorMesssage from "./ErrorMesssage.vue";
import Message from "./MessageComponent.vue";
import ArticleSearch from "./ArticleSearch.vue";

const app = createApp({
    // Configuration options
});

app.component('x-navigation', Navigation);
app.component('x-cookie-dialog', CookieDialog);
app.component('x-new-article', NewArticle);
app.component('x-cookie-disagree', CookieDisagree);
app.component('x-error-message', ErrorMesssage);
app.component('x-message', Message);
app.component('x-article-search', ArticleSearch);

app.mount('#app'); // Mount the Vue app to a specific HTML element
