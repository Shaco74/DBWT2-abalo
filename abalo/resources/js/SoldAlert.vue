<template>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import axios from "axios";

const connected = ref(false);
let socket;
let user_id;
let isLoggedin = false;

onMounted(async () => {
    await axios.get('/isloggedin').then(response => {
        user_id = response.data.user_id;
        isLoggedin = response.data.auth;
    });

    if(!isLoggedin) {
        return;
    }

    const socket = new WebSocket('ws://localhost:8085/sells');

    socket.onopen = function (event) {
        connected.value = true;
        console.log('WebSocket is connected. (Sold Alert)');
        console.log('User ID:', user_id);
    };

    socket.onmessage = function (event) {
        const message = JSON.parse(event.data);

        if (message.creatorId === user_id) {
            console.log('Received message:', message);
            swal("Artikel verkauft!", "Ihr Artikel " + message.articleName + " wurde erfolgreich verkauft!");
        }
    };

    socket.onclose = function (event) {
        console.log('WebSocket is closed.');
    };

    socket.onerror = function (error) {
        console.error('WebSocket error:', error);
    };
});

onUnmounted(() => {
    if (socket) {
        socket.close();
    }
});
</script>

<style lang="scss">
/* Add your styles here */
</style>
