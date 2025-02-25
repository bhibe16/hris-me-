<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unauthorized Access</title>
    <style>
        body { 
            text-align: center; 
            font-family: Arial, sans-serif; 
            background-color: #f8f9fa; 
            padding: 50px; 
        }
        .container {
            max-width: 500px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
        }
        h1 { color: red; }
        p { font-size: 18px; }
        a { text-decoration: none; color: blue; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <h1>403 - Unauthorized Access</h1>
        <p>You are not authorized to access this page.</p>
        <p><a href="{{ url('/login') }}">Go to Login</a></p>
    </div>
</body>
</html>
