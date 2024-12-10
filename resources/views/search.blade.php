<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>My Stories</title>
    <style>
        body { 
            margin: 0;
            font-family: Arial, sans-serif;
        }

        /* Navbar styling */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 30px;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .navbar-left {
            display: flex;
            align-items: center;
        }

        .website-name {
            font-size: 28px;
            font-weight: bold;
            margin-right: 20px;
            color: #007bff;
        }

        .navbar-center {
            flex-grow: 1;
            display: flex;
            justify-content: center;
        }

        .search-container {
            display: flex;
            align-items: center;
            background-color: #f0f0f0;
            border-radius: 20px;
            padding: 5px 15px;
            width: 50%;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .search-container input {
            width: 100%;
            border: none;
            background: none;
            outline: none;
            font-size: 16px;
        }

        .search-container i {
            font-size: 18px;
            color: #007bff;
            margin-left: 10px;
        }

        /* Posts container styling */
        .posts {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            justify-content: center;
            padding: 20px;
        }

        .post {
            width: calc(20% - 15px);
            background-color: #fff;
            padding: 10px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            cursor: pointer;
            transition: transform 0.3s;
        }

        .post:hover {
            transform: scale(1.05);
            box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.15);
        }

        .post img, .post video {
            width: 100%;
            height: 120px;
            object-fit: cover;
            border-radius: 8px;
        }

        .post-text {
            margin-top: 10px;
            font-size: 14px;
            font-weight: bold;
            color: #333;
        }

        /* Popup styles */
        .popup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .popup-content {
            position: relative;
            background: #fff;
            padding: 15px;
            border-radius: 10px;
            text-align: center;
            max-width: 600px; /* Increased size */
            max-height: 600px;
            overflow: hidden;
        }

        .popup img, .popup video {
            max-width: 100%;
            max-height: 500px; /* Adjusted for larger size */
            border-radius: 10px;
        }

        .popup .close {
            position: absolute;
            top: 10px;
            right: 10px;
            background: red;
            color: white;
            font-size: 20px;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            width: 30px;
            height: 30px;
        }

        .popup .close:hover {
            background: darkred;
        }
        .create-story,
        .register,
        .login {
            border: none;
            border-radius: 5px;
            padding: 10px 15px;
            cursor: pointer;
            color: white;
            background-color: #007bff;
            transition: background-color 0.3s;
            font-size: 16px;
        }

        .create-story:hover,
        .register:hover,
        .login:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-left">
            <span class="website-name"><big style="color: blue;">M</big>y<big style="color: blue;">S</big>tories</span>
            <a href="/"><i class="fa fa-home" style="font-size:25px; margin-left:30px; color: #007bff;"></i></a>
        </div>
        <div class="navbar-center">
            <div class="search-container">
                <input type="text" id="search-input" placeholder="Search by title...">
                <i class="fa fa-search"></i>
            </div>
        </div>
        <div class="navbar-right">
            @auth
                <a class="create-story" href="/create">Create</a>
            @else
            
            

            @endauth
        </div>
    </nav>

    <!-- Posts -->
    <div class="posts" id="post-container">
        @foreach ($stories as $story)
            <div class="post" data-title="{{ $story->title }}" data-media="{{ Storage::url($story->media_path) }}" data-type="{{ pathinfo(Storage::url($story->media_path), PATHINFO_EXTENSION) }}">
                @php
                    $fileExtension = pathinfo(Storage::url($story->media_path), PATHINFO_EXTENSION);
                @endphp

                @if (in_array($fileExtension, ['jpeg', 'jpg', 'png', 'gif']))
                    <img src="{{ Storage::url($story->media_path) }}" alt="Post Image">
                @elseif (in_array($fileExtension, ['mp4', 'mov', 'avi']))
                    <video muted>
                        <source src="{{ Storage::url($story->media_path) }}" type="video/{{ $fileExtension }}">
                    </video>
                @endif

                <p class="post-text">{{ $story->title }}</p>
            </div>
        @endforeach
    </div>

    <!-- Popup structure -->
    <div class="popup" id="popup">
        <div class="popup-content">
            <button class="close" id="popup-close">&times;</button>
            <div id="popup-media"></div>
        </div>
    </div>

    <script>
        // Popup functionality
        const posts = document.querySelectorAll('.post');
        const popup = document.getElementById('popup');
        const popupClose = document.getElementById('popup-close');
        const popupMedia = document.getElementById('popup-media');

        posts.forEach(post => {
            post.addEventListener('click', () => {
                const mediaPath = post.getAttribute('data-media');
                const mediaType = post.getAttribute('data-type');

                popupMedia.innerHTML = ''; // Clear previous content

                if (['jpeg', 'jpg', 'png', 'gif'].includes(mediaType)) {
                    const img = document.createElement('img');
                    img.src = mediaPath;
                    popupMedia.appendChild(img);
                } else if (['mp4', 'mov', 'avi'].includes(mediaType)) {
                    const video = document.createElement('video');
                    video.src = mediaPath;
                    video.controls = true;
                    video.autoplay = true;
                    popupMedia.appendChild(video);
                }

                popup.style.display = 'flex';
            });
        });

        popupClose.addEventListener('click', () => {
            popup.style.display = 'none';
            popupMedia.innerHTML = ''; // Clear popup content
        });

        popup.addEventListener('click', (e) => {
            if (e.target === popup) {
                popup.style.display = 'none';
                popupMedia.innerHTML = ''; // Clear popup content
            }
        });

        // Search functionality
        document.getElementById("search-input").addEventListener("input", function () {
            const query = this.value.toLowerCase();
            const posts = document.querySelectorAll(".post");
            posts.forEach(post => {
                const title = post.getAttribute("data-title").toLowerCase();
                if (title.includes(query)) {
                    post.style.display = "block";
                } else {
                    post.style.display = "none";
                }
            });
        });
    </script>
</body>
</html>
