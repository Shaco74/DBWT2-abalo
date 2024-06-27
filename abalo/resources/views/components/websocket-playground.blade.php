<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WebSocket Playground</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        #messages {
            border: 1px solid #ccc;
            padding: 10px;
            height: 300px;
            overflow-y: scroll;
            margin-bottom: 20px;
        }

        #messageForm {
            display: flex;
        }

        #messageForm input[type="text"] {
            flex: 1;
            padding: 10px;
            font-size: 16px;
        }

        #messageForm button {
            padding: 10px;
            font-size: 16px;
        }
    </style>
</head>
<body>
<h1>WebSocket Playground</h1>
<div id="messages"></div>
<form id="messageForm">
    <input type="text" id="messageInput" placeholder="Type a message..." required>
    <button type="submit">Send</button>
</form>

<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        const messagesDiv = document.getElementById('messages');
        const messageForm = document.getElementById('messageForm');
        const messageInput = document.getElementById('messageInput');

        // Replace 'ws://localhost:8080/chat' with your WebSocket server URL
        const socket = new WebSocket('ws://localhost:8085/chat');

        socket.onopen = () => {
            console.log('WebSocket connection established');
            messagesDiv.innerHTML += '<p><em>Connected to WebSocket server</em></p>';
        };

        socket.onmessage = (event) => {
            console.log('Message received:', event.data);
            // parse eventdata
            parsedDate = JSON.parse(event.data);
            if (parsedDate.isServer) {
                messagesDiv.innerHTML += `<p style="color: #0f6674;"><strong>Server:</strong> ${parsedDate.message}</p>`;
            } else {
                messagesDiv.innerHTML += `<p><strong>${parsedDate.sessionID}:</strong> ${parsedDate.message}</p>`;
            }
            messagesDiv.scrollTop = messagesDiv.scrollHeight;
        };

        socket.onclose = (event) => {
            console.log('WebSocket connection closed:', event);
            messagesDiv.innerHTML += '<p><em>Disconnected from WebSocket server</em></p>';
        };

        socket.onerror = (error) => {
            console.error('WebSocket error:', error);
            messagesDiv.innerHTML += '<p><em>Error occurred</em></p>';
        };

        messageForm.addEventListener('submit', (event) => {
            event.preventDefault();
            const message = messageInput.value;
            socket.send(message);
            messagesDiv.innerHTML += `<p><strong>You:</strong> ${message}</p>`;
            messageInput.value = '';
            messagesDiv.scrollTop = messagesDiv.scrollHeight;
        });
    });
</script>
</body>
</html>
