<?php
session_start();
require_once '../src/db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    $isPasswordValid = false;
    if ($user) {
        $storedPassword = (string) $user['password'];

        if (password_verify($password, $storedPassword)) {
            $isPasswordValid = true;
        } else {
            // Backward compatibility for older accounts that were saved as plain text.
            $passwordInfo = password_get_info($storedPassword);
            if ($passwordInfo['algo'] === null && hash_equals($storedPassword, $password)) {
                $isPasswordValid = true;
            }
        }
    }

    if ($isPasswordValid) {
        if (password_needs_rehash($user['password'], PASSWORD_BCRYPT)) {
            $rehashStmt = $pdo->prepare('UPDATE users SET password = ? WHERE id = ?');
            $rehashStmt->execute([password_hash($password, PASSWORD_BCRYPT), $user['id']]);
        }

        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['urole'];
        header('Location: index.php');
        exit();
    }

    $error = 'Invalid credentials. Please try again.';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - MelodyMine</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
</head>

<body>
    <?php if (!empty($error)): ?>
    <div class="status-wrap">
        <div class="alert alert-danger mt-3 mb-0" role="alert"><?php echo htmlspecialchars($error); ?></div>
    </div>
    <?php endif; ?>

    <section class="auth-page">
        <div class="auth-shell">
            <aside class="auth-aside">
                <i class="fas fa-headphones-alt"></i>
                <h2>Welcome Back</h2>
                <p>Log in to stream tracks, browse categories, and download your favorites.</p>
            </aside>

            <div class="auth-form-panel">
                <h1 class="auth-title">Login</h1>
                <p class="auth-subtitle">Pick up your music where you left off.</p>

                <form class="auth-form" method="POST" action="">
                    <input type="text" name="username" placeholder="Username" class="auth-input" required>
                    <input type="password" name="password" placeholder="Password" class="auth-input" required>
                    <button class="auth-btn btn btn-primary btn-block" name="login" type="submit">Login</button>
                    <p class="auth-switch">Don't have an account? <a href="register.php">Register here</a></p>
                </form>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
