<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chat Bot</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        body {
            font-family: Arial, sans-serif;
        }

        /* FLOAT BUTTON */
        .chat-toggle {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: #4e73df;
            color: white;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 24px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }

        /* CHAT BOX */
        .chat-box {
            position: fixed;
            bottom: 90px;
            right: 20px;
            width: 300px;
            height: 400px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            display: none;
            flex-direction: column;
        }

        .chat-header {
            background: #4e73df;
            color: white;
            padding: 10px;
            border-radius: 10px 10px 0 0;
        }

        .chat-body {
            flex: 1;
            padding: 10px;
            overflow-y: auto;
        }

        .chat-footer {
            display: flex;
            border-top: 1px solid #ddd;
        }

        .chat-footer input {
            flex: 1;
            border: none;
            padding: 10px;
        }

        .chat-footer button {
            border: none;
            background: #4e73df;
            color: white;
            padding: 10px;
            cursor: pointer;
        }

        .message {
            margin-bottom: 10px;
        }

        .user {
            text-align: right;
        }

        .bot {
            text-align: left;
        }
    </style>
</head>
<body>

<!-- CHAT BUTTON -->
<div class="chat-toggle" onclick="toggleChat()">
    💬
</div>

<!-- CHAT BOX -->
<div class="chat-box" id="chatBox">
    <div class="chat-header">
        Welcome To Coba Coba
    </div>

    <div class="chat-body" id="chatBody">
        <div class="message bot">Selamat datang warga coba coba!</div>
    </div>

    <div class="chat-footer">
        <input type="text" id="messageInput" placeholder="Ketik pesan...">
        <button onclick="sendMessage()">Kirim</button>
    </div>
</div>

<script>
    function toggleChat() {
        let box = document.getElementById("chatBox");
        box.style.display = box.style.display === "flex" ? "none" : "flex";
    }

    function appendMessage(text, type) {
        let chatBody = document.getElementById("chatBody");
        let div = document.createElement("div");
        div.classList.add("message", type);
        div.innerText = text;
        chatBody.appendChild(div);
        chatBody.scrollTop = chatBody.scrollHeight;
    }

    function sendMessage() {
        let input = document.getElementById("messageInput");
        let message = input.value;

        if (!message) return;

        appendMessage(message, "user");
        input.value = "";

        fetch("/chat/send", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            },
            body: JSON.stringify({
                message: message
            })
        })
        .then(res => res.json())
        .then(data => {
            appendMessage(data.message, "bot");
        })
        .catch(err => {
            appendMessage("Error...", "bot");
        });
    }
</script>

</body>
</html>