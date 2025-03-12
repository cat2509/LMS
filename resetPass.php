<?php
require 'config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["token"])) {
    $token = $_POST["token"];
    $newPassword = $_POST["password"];
    $confirmPassword = $_POST["confirm_password"];

    if ($newPassword !== $confirmPassword) {
        $_SESSION["error"] = "Passwords do not match.";
    } else {
        // Validate token
        $stmt = $conn->prepare("SELECT * FROM users WHERE reset_token = ?");
        $stmt->execute([$token]);
        $user = $stmt->fetch();

        if ($user) {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE users SET password = ?, reset_token = NULL WHERE reset_token = ?");
            $stmt->execute([$hashedPassword, $token]);

            $_SESSION["message"] = "Password updated successfully! Please log in.";
            header("Location: login.php");
            exit();
        } else {
            $_SESSION["error"] = "Invalid or expired token.";
        }
    }
}

$token = isset($_GET["token"]) ? $_GET["token"] : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        /* Reset styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #ffffff;
            margin: 0;
        }

        .banner {
            position: absolute;
            z-index: 1;
            background-color: #b91a1a;
            height: 7vh;
            width: 100%;
        }

        .container1 {
    display: flex;
    justify-content: center; /* Center horizontally */
    align-items: center; /* Center vertically */
    height: 100vh; /* Full viewport height */
    background-color: #ffffff;
    width: 100%;
}

.container {
    width: 29%;
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    text-align: center;
}


        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #444444;
        }

        p {
            font-size: 14px;
            color: gray;
            text-align: center;
            margin-bottom: 20px;
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

        /* === Password Visibility Toggle === */
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

        .error {
            color: red;
            margin-top: 10px;
        }

        .success {
            color: green;
            margin-top: 10px;
        }

        @media (max-width: 693px) {
            .container {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="banner"></div> <!-- Top banner -->
    
    <div class="container1">
        <div class="container">
            <h2>Reset Your Password</h2>
            <p>Enter a new password for your account.</p>

            <?php
            if (isset($_SESSION["error"])) {
                echo '<p class="error">' . $_SESSION["error"] . '</p>';
                unset($_SESSION["error"]);
            }
            if (isset($_SESSION["message"])) {
                echo '<p class="success">' . $_SESSION["message"] . '</p>';
                unset($_SESSION["message"]);
            }
            ?>

            <form action="resetPass.php" method="POST">
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">

                <div class="input">
                    <label for="password">New Password</label>
                    <div class="password-container">
                        <input type="password" id="password" name="password" required>
                        <span class="toggle-password" onclick="togglePassword('password')">&#128065;</span>
                    </div>
                </div>

                <div class="input">
                    <label for="confirm_password">Confirm Password</label>
                    <div class="password-container">
                        <input type="password" id="confirm_password" name="confirm_password" required>
                        <span class="toggle-password" onclick="togglePassword('confirm_password')">&#128065;</span>
                    </div>
                </div>

                <button type="submit">Update Password</button>
            </form>

            <p class="forgot-password"><a href="login.html">Back to Login</a></p>
        </div>
    </div>

    <script>
        function togglePassword(fieldId) {
            var field = document.getElementById(fieldId);
            field.type = field.type === "password" ? "text" : "password";
        }
    </script>
</body>
</html>
