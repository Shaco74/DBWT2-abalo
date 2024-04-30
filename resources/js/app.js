// resources/js/app.js
import { createApp } from 'vue';
import Navigation from './Navigation.vue'; // Example import of a Vue component

const app = createApp({
    // Configuration options
});

app.component('x-navigation', Navigation); // Register the Navigation component globally

app.mount('#app'); // Mount the Vue app to a specific HTML element
