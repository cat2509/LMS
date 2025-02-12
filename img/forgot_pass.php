<?php
require 'config.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Load PHPMailer

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);

    // Check if email exists in database
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        $token = bin2hex(random_bytes(50)); // Generate secure token
        $stmt = $conn->prepare("UPDATE users SET reset_token = ? WHERE email = ?");
        $stmt->execute([$token, $email]);

        // Send Reset Email
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'your-email@gmail.com'; // Your Gmail
            $mail->Password = 'your-app-password'; // Your Gmail App Password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('your-email@gmail.com', 'Your Website');
            $mail->addAddress($email);
            
            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Request';
            $mail->Body = "<p>Click the link below to reset your password:</p>
                          <a href='http://yourwebsite.com/resetPass.php?token=$token'>Reset Password</a>";

            $mail->send();
            $_SESSION["message"] = "A password reset link has been sent to your email.";
        } catch (Exception $e) {
            $_SESSION["error"] = "Email could not be sent. Mailer Error: " . $mail->ErrorInfo;
        }
    } else {
        $_SESSION["error"] = "No account found with that email.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="forgot-password.css">
</head>
<body>
    <div class="container">
        <h2>Forgot Password</h2>
        <?php
        if (isset($_SESSION["error"])) {
            echo '<p style="color:red;">' . $_SESSION["error"] . '</p>';
            unset($_SESSION["error"]);
        }
        if (isset($_SESSION["message"])) {
            echo '<p style="color:green;">' . $_SESSION["message"] . '</p>';
            unset($_SESSION["message"]);
        }
        ?>
        <form action="forgot_password.php" method="POST">
            <div class="input">
                <label for="email">Enter your email address:</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <button type="submit">Send Reset Link</button>
        </form>
        <p class="back-to-login">
            Remembered your password? <a href="login.html">Back to Login</a>
        </p>
    </div>
</body>
</html>
