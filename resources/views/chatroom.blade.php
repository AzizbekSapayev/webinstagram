<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Chat Interface</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: Arial, sans-serif;
      background-color: #e9f0f3;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .chat-container {
      width: 100%;
      max-width: 500px;
      height: 90vh;
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      display: flex;
      flex-direction: column;
      overflow: hidden;
    }

    .header {
      background-color: #128c7e;
      color: #fff;
      padding: 15px;
      display: flex;
      align-items: center;
      gap: 15px;
      font-size: 18px;
    }

    .back-button {
      cursor: pointer;
      color: #fff;
      font-size: 20px;
      font-weight: bold;
      text-decoration: none;
    }

    .chat-box {
      flex: 1;
      overflow-y: auto;
      padding: 15px;
      display: flex;
      flex-direction: column;
      gap: 10px;
      background-color: #e5ddd5;
    }

    .message {
      max-width: 75%;
      padding: 10px;
      border-radius: 10px;
      font-size: 14px;
      word-wrap: break-word;
    }

    .message.user {
      background-color: #dcf8c6;
      align-self: flex-end;
      text-align: right;
    }

    .message.chatmate {
      background-color: #fff;
      align-self: flex-start;
      text-align: left;
    }

    .input-container {
      display: flex;
      padding: 10px;
      background-color: #f0f0f0;
      align-items: center;
      gap: 10px;
    }

    .input-box {
      flex: 1;
      padding: 10px;
      border: none;
      border-radius: 20px;
      font-size: 16px;
      background-color: #e0e0e0;
    }

    .input-box:focus {
      outline: none;
    }

    .send-btn {
      background: none;
      border: none;
      cursor: pointer;
    }

    .send-btn img {
      width: 24px;
      height: 24px;
    }

    .notification {
      position: fixed;
      bottom: 20px;
      left: 50%;
      transform: translateX(-50%);
      background-color: #4caf50;
      color: white;
      padding: 10px 20px;
      border-radius: 5px;
      font-size: 14px;
      display: none;
    }
  </style>
</head>
<body>
  <div class="chat-container">
    <!-- Header -->
    <div class="header">
      <a href="/" class="back-button">←</a>
      Chat Room {{ $chatRoom->id }}
    </div>

    <!-- Chat Box -->
    <div class="chat-box" id="chat_box">
      @foreach ($messages as $message)
        @if ($message->sender_id == $user1->id)
          <div class="message user">
            <p>{{ $message->message }}</p>
          </div>
        @else
          <div class="message chatmate">
            <p>{{ $message->message }}</p>
          </div>
        @endif
      @endforeach
    </div>

    <!-- Input -->
    <div class="input-container">
      <input type="text" class="input-box" id="messageInput" placeholder="Type your message..." />
      <button class="send-btn" id="sendButton">
        <img src="https://cdn-icons-png.flaticon.com/128/9131/9131510.png" alt="Send" />
      </button>
    </div>
  </div>

  <div id="notification" class="notification"></div>

  <script>
    const roomid = "{{ $chatRoom->id }}";
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    document.getElementById("sendButton").addEventListener('click', () => {
      const messageInput = document.getElementById("messageInput");
      const chatBox = document.getElementById("chat_box");
      const notification = document.getElementById("notification");

      if (messageInput.value.trim() === "") {
        notification.textContent = "Message cannot be empty.";
        notification.style.display = "block";
        setTimeout(() => (notification.style.display = "none"), 3000);
        return;
      }

      fetch('/send-message', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': csrfToken,
        },
        body: JSON.stringify({
          'message': messageInput.value,
          'id': roomid,
        }),
      })
        .then(response => {
          if (!response.ok) {
            throw new Error('Failed to send message.');
          }
          return response.json();
        })
        .then(data => {
          chatBox.innerHTML += `
            <div class="message user">
              <p>${data.message}</p>
            </div>`;
          chatBox.scrollTop = chatBox.scrollHeight;
          messageInput.value = "";
        })
        .catch(error => {
          console.error('Error:', error);
        });
    });
  </script>
</body>
</html>
