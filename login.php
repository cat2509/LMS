<?php
// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Sample authentication logic (Replace with database authentication)
    if ($username === "admin" && $password === "password") {
        echo "<script>alert('Login successful!');</script>";
    } else {
        echo "<script>alert('Invalid credentials!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <script src="https://cdn.jsdelivr.net/npm/jwt-decode@3.1.2/build/jwt-decode.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ffffff;
            margin: 0;
        }
        .container1 {
            align-items: flex-start;
            padding-top: 50px;
            gap: 163px;
            background-color: #ffffff;
            border-radius: 8px;
            width: 87%;
            display: flex;
            justify-content: right;
            align-items: center;
            height: 88vh;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #444444;
        }
        .input {
            margin-bottom: 15px;
        }
        .input label {
            display: block;
            margin-bottom: 5px;
        }
        .input input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #444444;
            border-radius: 4px;
            color: #444444;
        }
        .password-container {
            position: relative;
            display: flex;
            align-items: center;
        }
        .password-container input {
            width: 100%;
            padding-right: 30px;
        }
        .toggle-password {
            position: absolute;
            right: 10px;
            cursor: pointer;
            font-size: 18px;
            user-select: none;
            color: #444444;
        }
        .toggle-password:hover {
            color: #b91a1a;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #b91a1a;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
            margin-bottom: 20px;
        }
        button:hover {
            background-color: #444444;
        }
        p {
            text-align: center;
            margin-top: 20px;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        .forgot-password {
            text-align: right;
            margin-top: 10px;
        }
        .forgot-password a {
            color: #444444;
            text-decoration: none;
        }
        .forgot-password a:hover {
            text-decoration: underline;
        }
        .banner {
            position: absolute;
            z-index: 1;
            background-color: #b91a1a;
            height: 7vh;
            width: 100%;
        }
        .logo {
            max-width: 100%;
            max-height: 80%;
            text-align: center;
        }
        .nav {
            position: absolute;
            z-index: 2;
            width: 20%;
            background-color: #ed1c24;
            height: 7vh;
        }
        .container {
            width: 29%;
        }
        @media (max-width: 693px) {
            .container {
                width: 100%;
            }
        }
        .imgcontainer {
            height: 112vh;
            overflow: hidden;
        }
        .bg-image {
            position: relative;
            top: -78px;
            width: 906px;
        }
    </style>
</head>
<body>
    <div class="nav"></div>
    <div class="banner"></div>
    <div class="container1">
        <div class="imgcontainer">
            <img class="bg-image" src="img/BG-login.jpg" alt="">
        </div>
        <div class="container">
            <div class="logo">
                <img src="img/Kjsit_logo.png" alt="">
            </div>
            <h2>Welcome to Somaiya</h2>
            <form action="login.php" method="post">
                <div class="input">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="input">
                    <label for="password">Password</label>
                    <div class="password-container">
                        <input type="password" id="password" name="password" required>
                        <span class="toggle-password">👁️</span>
                    </div>
                    <p class="forgot-password"><a href="forgot_pass.php">Forgot Password?</a></p>
                    <button type="submit">Login</button>
                    <div id="google-signin"></div>
                </div>
            </form>
        </div>
    </div>
    <script src="login.js"></script>
</body>
</html>
