<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>My stories</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<style>
    /* General improvements */
    body {
        margin: 0;
        font-family: Arial, sans-serif;
    }

    a {
        text-decoration: none;
    }

    /* Navbar Styling */
    .navbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 30px;
        background-color: white;
    }

    .navbar-left {
        display: flex;
        align-items: center;
        color:dimgrey;
    }

    .website-name {
        font-size: 28px;
        font-weight: bold;
        margin-right: 20px;
        color: #007bff;
    }

    
    .register,
    .login,
    .logout-btn,
    .username {
        border: none;
        border-radius: 5px;
        padding: 10px 15px;
        margin-left: 10px;
        cursor: pointer;
        color: white;
        background-color: #007bff;
        transition: background-color 0.3s;
        font-size: 16px;
    }
    .create-story{
        border: none;
        border-radius: 5px;
        padding: 10px 15px;
        margin-left: 10px;
        cursor: pointer;
        color: white;
        background-color:#28a745;
        transition: background-color 0.3s;
        font-size: 16px;
    }

    .create-story:hover,
    .register:hover,
    .login:hover,
    .logout-btn:hover,
    .username:hover {
        background-color: #0056b3;
    }

    /* Username styling */
    .username {
        background-color: #28a745;
        color: white;
    }

    /* Containers */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body, html {
        height: 100%;
        font-family: Arial, sans-serif;
    }

    .container {
        display: flex;
        height: 100vh;
        /* padding: 20px; */
    }

    /* Left side: User list */
    .user-list {
        flex: 1;
        background-color: #fff;
        border-right: 1px solid #ddd;
        padding: 20px;
        overflow-y: auto;
        /* box-shadow: 2px 0 6px rgba(0, 0, 0, 0.1); */
    }

    .user {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px;
        background-color: #f9f9f9;
        border-radius: 8px;
        margin-bottom: 15px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s;
    }

    .user:hover {
        transform: scale(1.03);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    .user-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        margin-right: 10px;
        border: 2px solid #ddd;
    }

    .user-name {
        font-size: 16px;
        font-weight: bold;
        color: #555;
    }

    .user a {
        text-decoration: none;
        color: #007bff;
        font-weight: bold;
        margin-left: 10px;
        transition: color 0.3s;
    }

    .user a:hover {
        color: #0056b3;
    }

    /* Right side: Posts */
    .posts {
        flex: 3;
        background-color: #fafafa;
        padding: 30px 20px;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 30px;
        align-items: center;
    }

    .post {
        width: 100%;
        max-width: 500px;
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        text-align: center;
        transition: transform 0.3s;
    }

    .post:hover {
        transform: scale(1.03);
        box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.15);
    }

    .post-image {
        width: 100%;
        height: auto;
        border-radius: 8px;
        margin-bottom: 15px;
    }

    .post-text {
        margin-top: 10px;
        font-size: 18px;
        color: #333;
    }

    /* Video container */
    .video-container {
        position: relative;
        display: inline-block;
    }

    .post-video {
        width: 100%;
        height: auto;
        border-radius: 8px;
    }

    .volume-icon {
        position: absolute;
        bottom: 10px;
        right: 10px;
        background-color: rgba(0, 0, 0, 0.5);
        color: white;
        border: none;
        border-radius: 50%;
        padding: 8px 12px;
        cursor: pointer;
        font-size: 18px;
    }
    

</style>

<body>
    <nav class="navbar">
        <div class="navbar-left">
            <span class="website-name"> <big style="color: blue;">M</big>y<big style="color: blue;">S</big>tories</span>
            @auth
            <a class="create-story" href="/create">create</a>
            <a href="/search"><i class="fa fa-search" style="font-size:25px; margin-left:30px; color: #007bff; "></i> </a>
            <a href="/reels" style="margin-left:30px;"><i class="fa fa-video-camera" style="font-size:25px;color: #007bff"></i> </a> <!-- Reels Icon -->
            @endauth
        </div>
        <div>
            @if (auth()->user()->hasRole('admin'))
                <a href="/controllusers" style="padding:10px; border-radius:5px; background-color:#007bff; color:white;">Manage Users</a>
            @endif
        </div>
        @auth
            <div style="display: flex; gap:20px;">
                <!-- Logout Button with username -->
<form method="POST" action="{{ route('logout') }}" style="display: flex; gap:20px;">
    @csrf
    <button class="logout-btn" type="submit">{{ __('Log Out') }}</button>
    <a href="/dashboard" class="username">{{ $user->name }}</a>
</form>

            </div>
        @else
        <div class="navbar-right">
            <a class="register" href="{{ route('register') }}">Register</a>
            <a class="login" href="{{ route('login') }}">Login</a>
        </div>
        @endauth
    </nav>
    


    <div class="container">
        <!-- Left side: list of users -->
        <div class="user-list">
            @foreach ($users as $us)
                <div class="user" style="display:flex;">
                    <div style="display: flex; align-items:center;">
                        <img src="data:image/png;base64,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" alt="User Avatar" class="user-avatar">
                        <p class="user-name">{{ $us->name }}</p>
                    </div>
                    <a href="create-room/{{ $us->id }}">Chat</a>
                    <!-- Check if the user is followed by the currently logged-in user -->
                    @if (in_array($us->id, $followedUsers))
                        <!-- If the user is followed, show Unfollow link -->
                        <a href="/unfollow/{{ $us->id }}">Unfollow</a>
                    @else
                        <!-- If the user is not followed, show Follow link -->
                        <a href="/follow/{{ $us->id }}">Follow</a>
                    @endif
                </div>
            @endforeach

            
            <!-- Add more users as needed -->
        </div>

        <!-- Right side: posts -->
        <div class="posts">

            @foreach ($stories as $story)
    <div class="post">
        <strong style="text-align: left; display:block; margin-bottom:15px;">
            @ {{ $story->user->name ?? 'Unknown User' }}  
            {{ \Carbon\Carbon::parse($story->created_at)->diffForHumans() }}
        </strong>

        @php
            $fileExtension = pathinfo(Storage::url($story->media_path), PATHINFO_EXTENSION);
        @endphp

        @if (in_array($fileExtension, ['jpeg', 'jpg', 'png', 'gif']))
            <!-- If the media is an image -->
            <img src="{{ Storage::url($story->media_path) }}" alt="Post Image" class="post-image">
        @elseif (in_array($fileExtension, ['mp4', 'mov', 'avi']))
            <!-- If the media is a video -->
            <div class="video-container">
                <video class="post-video" autoplay loop muted>
                    <source src="{{ Storage::url($story->media_path) }}" type="video/{{ $fileExtension }}">
                    Your browser does not support the video tag.
                </video>
                <button class="volume-icon" onclick="toggleVolume(this)">
                    🔇
                </button>
            </div>
        @endif

        <p class="post-text"><b>{{ $story->title }}</b></p>
        <p>{{ $story->description }}</p>
    </div>
    <hr style="border: 1px solid gray; width:405px;">
@endforeach


            <!-- Add more posts as needed -->
        </div>
    </div>
    <script>
        function toggleVolume(button) {
    const video = button.previousElementSibling; // Get the video element
    if (video.muted) {
        video.muted = false;
        button.textContent = '🔊'; // Change icon to sound on
    } else {
        video.muted = true;
        button.textContent = '🔇'; // Change icon to sound off
    }
}

    </script>
</body>
</html>