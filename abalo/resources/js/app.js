import { createApp } from 'vue';
import Navigation from './Navigation.vue';
import NewArticle from "./NewArticle.vue";
import CookieDialog from './util/CookieDialog.vue'
import CookieDisagree from "./CookieDisagree.vue";
import ErrorMesssage from "./ErrorMesssage.vue";
import Message from "./MessageComponent.vue";
import ArticleSearch from "./ArticleSearch.vue";
import Footer from "./Footer.vue";
import Body from "./Body.vue";
import Impressum from "./Impressum.vue";
import { create, all } from 'mathjs';



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
app.component('x-footer', Footer);
app.component('x-body', Body);
app.component('x-impressum', Impressum);

app.mount('#app'); // Mount the Vue app to a specific HTML element

// P4 T3: Math.js
const math = create(all);

window.calculateCartTotal = function() {
    let cartItems = document.querySelectorAll('.cart-item');
    let total = 0;

    cartItems.forEach(item => {
        let price = parseFloat(item.querySelector('.item-price').innerText);
        total = math.add(total, price);
    });

    document.getElementById('cart-total').innerText = total.toFixed(2);
    return total;
}

window.calculateCartItems = function() {
    let cartItems = document.querySelectorAll('.cart-item');
    let total = 0;

    cartItems.forEach(item => {
        total++;
    });

    document.getElementById('cart-items').innerText = total;
    return total;
}

window.calculateAverage = function() {
    let grades = calculateCartItems();
    let total =  calculateCartTotal();

    if (grades === 0) {
        document.getElementById('average').innerText = 0;
        return;
    }
    document.getElementById('average').innerText = math.divide(total, grades).toFixed(2);
}

document.addEventListener('DOMContentLoaded', (event) => {
    // ich lasse das snippet hier, eventuell wird es im nächsten Meilenstein nützlich
  /*  const socket = new WebSocket('ws://localhost:8085/sells');

    socket.onopen = function(event) {
        console.log('WebSocket is connected.');
    };

    socket.onmessage = function(event) {
        const message = JSON.parse(event.data);
        console.log('Received message:', message);

        if (message.creatorId === 'uuid-123') {
            alert('Your item has been sold!');
        }
    };

    socket.onclose = function(event) {
        console.log('WebSocket is closed.');
    };

    socket.onerror = function(error) {
        console.error('WebSocket error:', error);
    };*/
});
