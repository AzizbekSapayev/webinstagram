<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Story</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f4f8;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .back-button {
    position: absolute;
    top: 20px;
    left: 20px;
    font-size: 16px;
    font-weight: bold;
    color: #007BFF;
    text-decoration: none;
    background-color: #fff;
    padding: 5px 10px;
    border-radius: 5px;
    border: 1px solid #007BFF;
    transition: background-color 0.3s, color 0.3s;
}

.back-button:hover {
    background-color: #007BFF;
    color: #fff;
}
.notification {
    position: fixed;
    top: 10px;
    left: 50%;
    transform: translateX(-50%);
    background-color: #4CAF50;
    color: white;
    padding: 10px 20px;
    border-radius: 5px;
    font-size: 16px;
    font-weight: bold;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.5s ease, visibility 0.5s ease;
    z-index: 1000;
}
.notification.show {
    opacity: 1;
    visibility: visible;
}



        .form-container {
            background-color: #fff;
            width: 400px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .form-container h2 {
            font-size: 24px;
            text-align: center;
            margin-bottom: 20px;
            color: #007BFF;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .form-group textarea {
            resize: none;
            height: 100px;
        }

        .form-group input[type="file"] {
            padding: 5px;
            font-size: 14px;
        }

        .submit-button {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            color: #fff;
            background-color: #007BFF;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .submit-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <body>
        <!-- Back button -->
        <a href="/" class="back-button">← Back</a>
    
        <!-- Notification -->
        <div id="notification" class="notification">Story successfully created!</div>
    
        <!-- Form -->
        <form action="{{ route('savestory') }}" method="post" enctype="multipart/form-data" class="form-container">
            @csrf
            <h2>Create New Story</h2>
            <div class="form-group">
                <label for="title">Story Title</label>
                <input type="text" id="title" name="title" placeholder="Enter story title" required>
            </div>
            <div class="form-group">
                <label for="description">Story Description</label>
                <textarea id="description" name="description" placeholder="Write your story description..." required></textarea>
            </div>
            <div class="form-group">
                <label for="media">Upload Media</label>
                <input type="file" id="media" name="media" accept="image/*,video/*" required>
            </div>
            <button type="submit" class="submit-button">Create Story</button>
        </form>
    
        <!-- Success Alert -->
        @if (session('success'))
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    const notification = document.getElementById('notification');
                    notification.textContent = "{{ session('success') }}"; // Set success message
                    notification.classList.add('show'); // Show notification
    
                    // Hide notification after 3 seconds
                    setTimeout(() => {
                        notification.classList.remove('show');
                    }, 3000);
                });
            </script>
        @endif
    
        <script>
            // Optionally, handle client-side validation or other notifications here.
        </script>
    </body>
    
</body>
</html>
