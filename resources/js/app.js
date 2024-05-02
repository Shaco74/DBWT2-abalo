import { createApp } from 'vue';
import Navigation from './Navigation.vue';
import CookieDialog from './util/CookieDialog.vue'

const app = createApp({
    // Configuration options
    components: {
        'x-navigation': Navigation,
        'x-cookie-dialog': CookieDialog
    },
});

app.mount('#app'); // Mount the Vue app to a specific HTML element
