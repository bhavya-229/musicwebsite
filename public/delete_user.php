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

// Delete user if confirmed
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <title>Delete User</title>
</head>
<body>
<div class="card mb-4 mt-5" style="align-self: center;width: 600px;">
    <div class="card-header">
        <h3 class="card-title">Delete User</h3>
    </div>
    <div class="card-body">
    <p>Are you sure you want to delete the user <strong><?= $user['username'] ?></strong>?</p>
    <form method="POST" action="">
        <button class="btn btn-info" type="submit">Yes, Delete</button>
        <a class="btn btn-danger" href="admin_dashboard.php">Cancel</a>
    </form>
    </div>
</div>
</body>
</html>
