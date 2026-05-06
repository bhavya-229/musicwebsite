<?php
session_start();
require_once '../src/db.php';

// Only allow admins to access the page
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

// Check if the user ID is passed in the query string
if (isset($_GET['id'])) {
    $userId = $_GET['id'];
    
    // Fetch user details from the database
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    $user = $stmt->fetch();
    
    if (!$user) {
        echo "User not found!";
        exit;
    }
} else {
    header('Location: admin_dashboard.php');
    exit;
}

// Update user information
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['urole'];

    $stmt = $pdo->prepare("UPDATE users SET username = ?, email = ?, urole = ? WHERE id = ?");
    $stmt->execute([$username, $email, $role, $userId]);

    header('Location: admin_dashboard.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
</head>
<body>
<div class="card mb-4 mt-5" style="align-self: center;width: 600px;">
    <div class="card-header ">
        <h3 class="card-title">Edit User</h3>
    </div>
    <div class="card-body">
    
    <form method="POST" action="">
        <label>Username:</label>
        <input type="text" class="form-control" name="username" value="<?= $user['username'] ?>" required>
        <label>Email:</label>
        <input type="email" class="form-control" name="email" value="<?= $user['email'] ?>" required>
        <label>Role:</label>
        <select class="form-control" name="urole">
            <option  value="client" <?= $user['urole'] === 'user' ? 'selected' : '' ?>>Client</option>
            <option value="admin" <?= $user['urole'] === 'admin' ? 'selected' : '' ?>>Admin</option>
        </select>
        <button class="btn btn-info mt-3"type="submit">Update User</button>
    </form>
    </div>
    </div>
</body>
</html>
