<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

require_once '../src/db.php';

$users = $pdo->query('SELECT * FROM users')->fetchAll();
$music = $pdo->query('SELECT * FROM music')->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/admin.css">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg admin-navbar">
            <a class="navbar-brand" href="index.php">MelodyMine Admin</a>
            <div class="ml-auto">
                <a class="btn btn-danger" href="logout.php">Logout</a>
            </div>
        </nav>
    </header>

    <main class="admin-wrap">
        <section class="admin-section">
            <h2>Manage Users</h2>
            <p class="section-subhead">Review, edit, and remove user accounts.</p>
            <div class="table-shell">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= htmlspecialchars($user['id']) ?></td>
                            <td><?= htmlspecialchars($user['username']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td><?= htmlspecialchars($user['urole']) ?></td>
                            <td>
                                <a href="edit_user.php?id=<?= urlencode($user['id']) ?>" class="btn btn-warning">Edit</a>
                                <a href="delete_user.php?id=<?= urlencode($user['id']) ?>" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <section class="admin-section">
            <h2>Manage Music</h2>
            <p class="section-subhead">Update tracks or upload fresh music for users.</p>
            <div class="admin-toolbar">
                <a href="upload.php" class="btn btn-primary">Add New Music</a>
            </div>
            <div class="table-shell">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Artist</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($music as $track): ?>
                        <tr>
                            <td><?= htmlspecialchars($track['id']) ?></td>
                            <td><?= htmlspecialchars($track['title']) ?></td>
                            <td><?= htmlspecialchars($track['artist']) ?></td>
                            <td>
                                <a href="edit_music.php?id=<?= urlencode($track['id']) ?>" class="btn btn-warning">Edit</a>
                                <a href="delete_music.php?id=<?= urlencode($track['id']) ?>" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
