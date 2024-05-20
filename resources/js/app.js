import { createApp } from 'vue';
import Navigation from './Navigation.vue';
import NewArticle from "./NewArticle.vue";
import CookieDialog from './util/CookieDialog.vue'
import CookieDisagree from "./CookieDisagree.vue";
import ErrorMesssage from "./ErrorMesssage.vue";
import Message from "./MessageComponent.vue";

const app = createApp({
    // Configuration options
    components: {
        'x-navigation': Navigation,
        'x-cookie-dialog': CookieDialog,
        'x-new-article': NewArticle,
        'x-cookie-disagree': CookieDisagree,
        'x-error-message': ErrorMesssage,
        'x-message': Message,
    },
});

app.mount('#app'); // Mount the Vue app to a specific HTML element
