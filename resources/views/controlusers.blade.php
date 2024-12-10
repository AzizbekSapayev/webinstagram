<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User Management</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            width: 80%;
            max-width: 800px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-top: 20px;
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
            font-size: 24px;
        }
        .user-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            margin: 10px 0;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }
        .user-item p {
            font-size: 18px;
            color: #555;
            margin: 0;
        }
        .user-item a {
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }
        .user-item a.blocked {
            background-color: #f44336;
            color: #fff;
        }
        .user-item a.blocked:hover {
            background-color: #d32f2f;
        }
        .user-item a.block {
            background-color: #4caf50;
            color: #fff;
        }
        .user-item a.block:hover {
            background-color: #388e3c;
        }
        .user-item a {
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>User Management</h1>
        @foreach ($users as $user)
            <div class="user-item">
                <p>{{$user->name}}</p>
                @if ($user->hasRole('blocked'))
                    <a href="/unblock/{{$user->id}}" class="blocked">Blocked</a>
                @else
                    <a href="/blockUser/{{$user->id}}" class="block">Block User</a>
                @endif
            </div>
        @endforeach
    </div>
</body>
</html>
