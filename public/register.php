<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Music Website</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
</head>

<body>
    <div class="signup-container">
        <!-- Data or Content -->
        <div class="box-1">
            <div class="log-content-holder">
                <i class="fas fa-user" style="font-size: 100px; margin-top: 60px;"></i>
            </div>
        </div>

        <!-- Forms -->
        <div class="box-2">
            <!-- Create Container for Signup form -->
            <div class="signup-form-container">
                <h1 style="margin-top:-20px">Register Form</h1>

                <form method="POST" action="">
                    <input type="text" name="username" placeholder="Username" class="input-field" required>
                    <br><br>
                    <input type="password" name="password" placeholder="Password" class="input-field" required>
                    <br><br>
                    <input type="text" name="email" placeholder="Email" class="input-field" required>
                    <br><br>
                    
                    <button class="signup-button" type="submit">Register</button>
                    <div class="text-center" style="margin-top: 5px;">
                        <p>Already have an account? <a href="login.php">Login here</a></p>
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
require_once '../src/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $email=$_POST['email'];

    $stmt = $pdo->prepare('INSERT INTO users (username, password , email) VALUES (?, ?,?)');
    if ($stmt->execute([$username, $password,$email])) {
        echo '<div style="margin-top : -40px;" class="alert alert-success" role="alert">User registered successfully</div>';
    } else {
        echo '<div style="margin-top : -40px; class="alert alert-danger" role="alert">Error registering user</div>';
    }
}
?>