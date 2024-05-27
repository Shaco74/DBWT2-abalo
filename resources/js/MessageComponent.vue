<!-- P3:  Aufgabe 1-->
<template>
    <div>
        <div id="title" class="text-center text-2xl"></div>
        <div class="flex justify-center ">
            <div id="message" class="text-center text-xl mt-4 bg-zinc-900 rounded px-1"></div>
        </div>

    </div>
</template>

<script>
/*
* P3:  Task 1
* Create a Vue component that fetches a JSON file from the server and displays the content in the browser.
* */
export default {
    data() {
        return {
            title: '',
            message: '',
            message2: '',
            message3: '',
            selectedMessage: ''
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
