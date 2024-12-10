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
        /* User Profile Section */
       .profile {
    text-align: center;
    padding: 20px;
    width: 100%;
    max-width: 800px;
    margin: 40px auto; /* O'rtaga joylash */
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    position: relative; /* Yangi qo'shildi */   
}

.create-story {
    display: block;
    width: 100px;
    margin: 20px auto 0; /* O'rtaga joylash va pastga ko'chirish */
    position: relative; /* Konteyner ichida joylashish */
    bottom: 0; /* Tugmani pastga o'rnatish */
}


        .profile img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 10px;
            border: 2px solid #007BFF;
        }

        .profile h2 {
            font-size: 24px;
            color: #333;
        }

        .profile-info {
            font-size: 14px;
            color: #555;
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 10px;
        }

        .profile-info div {
            text-align: center;
        }

        .profile-info span {
            display: block;
            font-size: 18px;
            font-weight: bold;
            color: #007BFF;
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
            background: #007bff;
            color: white;
            font-size: 20px;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            width: 30px;
            height: 30px;
        }

        .popup .close:hover {
            background: #007bff;
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

        .delete-button {
    margin-top: 10px;
    padding: 8px 16px;
    border: none;
    background-color: #e63946; /* Red for Delete */
    color: white;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
    font-weight: bold;
    transition: background-color 0.3s, transform 0.2s;
}

.delete-button:hover {
    background-color: #d62828;
}

.delete-button:active {
    transform: scale(0.98);
}

.delete-button:focus {
    outline: 2px solid #d62828;
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
                
            @else
            
         

            @endauth
        </div>
    </nav>
    <!-- User Profile Section -->
    <div class="profile">
        <img src="https://cdn-icons-png.flaticon.com/128/17701/17701286.png" alt="User Icon">
        <h2>{{ $user->name }}</h2>
        <div class="profile-info">
            <div>
                <span>{{ count($stories) }}</span> Posts
            </div>
            <div>
                <span>{{ $followingCount }}</span> Following
            </div>
        </div>
        <a class="create-story" href="/create">Create</a>
    </div>

    <!-- Posts -->
   <!-- Posts -->
<div class="posts" id="post-container">
    @foreach ($stories as $story)
        <div class="post" data-id="{{ $story->id }}" data-title="{{ $story->title }}" data-media="{{ Storage::url($story->media_path) }}" data-type="{{ pathinfo(Storage::url($story->media_path), PATHINFO_EXTENSION) }}">
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

            <!-- Delete Button -->
            <a href="/delete/{{$story->id}}">Delete</a>
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

        document.addEventListener('DOMContentLoaded', function () {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Attach event listeners to all delete buttons
    document.querySelectorAll('.delete-button').forEach(button => {
        button.addEventListener('click', function (e) {
            e.stopPropagation(); // Prevent triggering the popup

            const postId = this.getAttribute('data-id');
            if (confirm('Are you sure you want to delete this post?')) {
                fetch(`/stories/${postId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken, // Include CSRF token
                    },
                })
                .then(response => {
                    if (response.ok) {
                        // Remove the post from the DOM
                        this.closest('.post').remove();
                        alert('Post deleted successfully.');
                    } else {
                        alert('Failed to delete the post.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while deleting the post.');
                });
            }
        });
    });
});

    </script>
</body>
</html>
