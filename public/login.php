<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Music Website</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
</head>
<body>
<div class="log-container">
        <!-- Data or Content -->
        <div class="box-1">
            <div class="log-content-holder">
            <i class="fas fa-user" style="font-size: 100px; margin-top: 60px;"></i>
            </div>
        </div>
        <!-- Login Form -->
        <div class="box-2">
            <div class="login-form-container">
                <h1>Login Form</h1>

                    <form  method="POST" action="">
                    <input type="text" name="username" placeholder="Username" class="input-field" required>
                    <br><br>
                    <input type="password" name="password" placeholder="Password" class="input-field" required>
                    <br><br>
                    <button class="login-button" name="login" type="submit">Login</button>
                    <div class="text-center" style="margin-top: 5px;">
                <p>Don't have an account? <a href="register.php">Register here</a></p>
            </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
session_start();
require_once '../src/db.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
     $username = $_POST['username'];
     $password = $_POST['password'];


    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['urole'];
        header('Location: index.php');
    } else {
        echo '<div style="margin-top:10px" class="alert alert-danger" role="alert">Invalid credentials</div>';
    }
}
?>
