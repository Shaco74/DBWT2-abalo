<template>
    <v-dialog v-model="dialog" max-width="500">
        <v-card v-if="alertMessage">
            <v-card-title class="headline">Rabatt Info!</v-card-title>
            <v-card-text>
                Der Artikel <strong>{{ alertMessage.articleName }}</strong> wird nun günstiger angeboten:
                <strong>{{ alertMessage.discountPercentage }}%</strong> billiger! Greifen Sie schnell zu!
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="primary" @click="dialog = false">Close</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script setup>
import {ref, onMounted, onUnmounted} from 'vue';
import {getLoginContext} from './util/getLoginContext.js';

const connected = ref(false);
const dialog = ref(false);
const alertMessage = ref(null);
let socket;
let user_id;
let isLoggedin = false;

onMounted(async () => {
    const loginContext = await getLoginContext();
    user_id = loginContext.userId;
    isLoggedin = loginContext.isLoggedIn;

    if (!isLoggedin) {
        return;
    }

    socket = new WebSocket('ws://localhost:8085/discount-alert');

    socket.onopen = function (event) {
        connected.value = true;
        console.log('WebSocket is connected. (Discount Alert)');
        console.log('User ID:', user_id);
    };

    socket.onmessage = function (event) {
        const message = JSON.parse(event.data);

        if (message.userIds.includes(user_id)) {
            console.log('Received discount alert:', message);
            alertMessage.value = message;
            dialog.value = true;
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
