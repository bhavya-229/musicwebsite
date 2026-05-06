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
    $stmt = $pdo->prepare('DELETE FROM users WHERE id = ?');
    $stmt->execute([$userId]);

    header('Location: admin_dashboard.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete User</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <div class="card form-card danger-card">
        <div class="card-header">
            <h3 class="card-title">Delete User</h3>
        </div>
        <div class="card-body">
            <p>Are you sure you want to delete the user <strong><?= htmlspecialchars($user['username']) ?></strong>?</p>
            <form method="POST" action="">
                <button class="btn btn-danger" type="submit">Yes, Delete</button>
                <a class="btn btn-outline-secondary ml-2" href="admin_dashboard.php">Cancel</a>
            </form>
        </div>
    </div>
</body>

</html>
