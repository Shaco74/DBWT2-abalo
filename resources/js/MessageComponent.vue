<!-- P3:  Aufgabe 1-->
<template xmlns="http://www.w3.org/1999/html">
    <div class="grid">
        <div id="title" class="text-center text-2xl"></div>
        <div class="flex justify-center ">
            <div id="message" class="text-center text-xl mt-4 bg-zinc-900 rounded px-1"></div>
        </div>
        <div class="flex">
        <div class="basis-1/4"></div>
        <div class="flex justify-center basis-1/2">
            <p class="mt-8 p-1 dotted border-t-2 border-l-2 border-current w-1/2"> <button @click="countUp">Count up</button> {{ count }}</p>
            <p class="mt-8 p-1 pl-2 dotted border-b-2 border-r-2 border-current w-1/2"><button @click="addRandom">Random Number</button>  {{ random }} </p>
        </div>
        <div class="basis-1/4"></div>
    </div>
    </div>
</template>

<script>
import {add, random} from "mathjs";
//using math js to do something cool


/*
* P3:  Task 1
* Create a Vue component that fetches a JSON file from the server and displays the content in the browser.
* */
export default {
    methods: {
        countUp() {
            this.count = add(this.count, 1);
        },
        addRandom() {
            this.random = random(0, 100);
        }
    },
    data() {
        return {
            title: '',
            message: '',
            message2: '',
            message3: '',
            selectedMessage: '',
            count: 0,
            random: 0
        };
    },
    created() {
        document.addEventListener('DOMContentLoaded', function() {
            let currentMessageIndex = 0;
            let messages = [];
            const messageElement = document.getElementById('message');

            function fetchMessages() {
                const xhr = new XMLHttpRequest();
                xhr.open('GET', '/static/message.json', true);
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        const data = JSON.parse(xhr.responseText);
                        messages = [data.message, data.message2, data.message3];
                        document.getElementById('title').textContent = data.title;
                        updateMessage();
                        setInterval(updateMessage, 6000);
                    }
                };
                xhr.send();
            }

            function updateMessage() {
                messageElement.classList.remove('active');
                setTimeout(() => {
                    messageElement.textContent = messages[currentMessageIndex];
                    messageElement.classList.add('active');
                    currentMessageIndex = (currentMessageIndex + 1) % messages.length;
                }, 500); // Delay to ensure previous content fades out before new content fades in
            }

            fetchMessages();
        });
    }
};
</script>

<style scoped>
#title {
    font-size: 2em;
    color: #808080;
    display: flex;
    justify-content: center;
    margin: 0.5em 0;
}

/* CSS */
#message {
    opacity: 0;
    transform: translate(0, 1em);
    transition: opacity 0.5s ease-in-out, transform 0.5s ease-in-out;
}

#message.active {
    opacity: 1;
    transform: translateX(0);
}
</style>
