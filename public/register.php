<?php
require_once '../src/db.php';

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $email = $_POST['email'];

    $stmt = $pdo->prepare('INSERT INTO users (username, password, email) VALUES (?, ?, ?)');
    if ($stmt->execute([$username, $password, $email])) {
        $success = 'User registered successfully. You can log in now.';
    } else {
        $error = 'Error registering user. Please try again.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - MelodyMine</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
</head>

<body>
    <?php if (!empty($success)): ?>
    <div class="status-wrap">
        <div class="alert alert-success mt-3 mb-0" role="alert"><?php echo htmlspecialchars($success); ?></div>
    </div>
    <?php endif; ?>
    <?php if (!empty($error)): ?>
    <div class="status-wrap">
        <div class="alert alert-danger mt-3 mb-0" role="alert"><?php echo htmlspecialchars($error); ?></div>
    </div>
    <?php endif; ?>

    <section class="auth-page">
        <div class="auth-shell">
            <aside class="auth-aside">
                <i class="fas fa-compact-disc"></i>
                <h2>Join MelodyMine</h2>
                <p>Create your account and start exploring your next favorite songs.</p>
            </aside>

            <div class="auth-form-panel">
                <h1 class="auth-title">Create Account</h1>
                <p class="auth-subtitle">Sign up to stream and download music.</p>

                <form class="auth-form" method="POST" action="">
                    <input type="text" name="username" placeholder="Username" class="auth-input" required>
                    <input type="password" name="password" placeholder="Password" class="auth-input" required>
                    <input type="email" name="email" placeholder="Email" class="auth-input" required>
                    <button class="auth-btn btn btn-primary btn-block" type="submit">Register</button>
                    <p class="auth-switch">Already have an account? <a href="login.php">Login here</a></p>
                </form>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
