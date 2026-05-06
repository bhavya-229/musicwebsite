<?php
session_start();
require_once '../src/db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    $stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
    $stmt->execute([$userId]);
    $user = $stmt->fetch();

    if (!$user) {
        echo 'User not found!';
        exit;
    }
} else {
    header('Location: admin_dashboard.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['urole'];

    $stmt = $pdo->prepare('UPDATE users SET username = ?, email = ?, urole = ? WHERE id = ?');
    $stmt->execute([$username, $email, $role, $userId]);

    header('Location: admin_dashboard.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <div class="card form-card">
        <div class="card-header">
            <h3 class="card-title">Edit User</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input id="username" type="text" class="form-control" name="username"
                        value="<?= htmlspecialchars($user['username']) ?>" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" class="form-control" name="email"
                        value="<?= htmlspecialchars($user['email']) ?>" required>
                </div>

                <div class="form-group">
                    <label for="urole">Role</label>
                    <select id="urole" class="form-control" name="urole">
                        <option value="client" <?= $user['urole'] === 'client' ? 'selected' : '' ?>>Client</option>
                        <option value="admin" <?= $user['urole'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                    </select>
                </div>

                <button class="btn btn-primary" type="submit">Update User</button>
                <a href="admin_dashboard.php" class="btn btn-outline-secondary ml-2">Cancel</a>
            </form>
        </div>
    </div>
</body>

</html>
