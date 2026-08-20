<!DOCTYPE html>
<html>
<head>
    <title>AI Chatbot</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

<h2>AI Assistant</h2>

<div id="chat-box"></div>

<input type="text" id="message">
<button onclick="sendMessage()">Send</button>

<script>
async function sendMessage() {

    let message = document.getElementById('message').value;

    let response = await fetch('/kiosk/ai-chat', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN':
                document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            message: message
        })
    });

    let data = await response.json();

    document.getElementById('chat-box').innerHTML +=
        "<p><b>You:</b> " + message + "</p>";

    document.getElementById('chat-box').innerHTML +=
        "<p><b>AI:</b> " + data.reply + "</p>";
}
</script>

</body>
</html>