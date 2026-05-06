<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

require_once '../src/db.php';

if (isset($_POST['update_music'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $artist = $_POST['artist'];
    $category = $_POST['category'];

    if (!empty($_FILES['music_file']['name'])) {
        $file_path = 'uploads/' . basename($_FILES['music_file']['name']);
        move_uploaded_file($_FILES['music_file']['tmp_name'], '../src/' . $file_path);
    } else {
        $file_path = $_POST['existing_file_path'];
    }

    $stmt = $pdo->prepare('UPDATE music SET title = ?, artist = ?, category = ?, file_path = ? WHERE id = ?');
    $stmt->execute([$title, $artist, $category, $file_path, $id]);

    header('Location: admin_dashboard.php');
    exit();
}

$music = null;
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare('SELECT * FROM music WHERE id = ?');
    $stmt->execute([$id]);
    $music = $stmt->fetch();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Music</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <div class="card form-card">
        <div class="card-header">
            <h3 class="card-title">Edit Music</h3>
        </div>
        <div class="card-body">
            <?php if ($music): ?>
            <form action="edit_music.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($music['id']); ?>">
                <input type="hidden" name="existing_file_path" value="<?php echo htmlspecialchars($music['file_path']); ?>">

                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" name="title" id="title"
                        value="<?php echo htmlspecialchars($music['title']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="artist">Artist</label>
                    <input type="text" class="form-control" name="artist" id="artist"
                        value="<?php echo htmlspecialchars($music['artist']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="category">Category</label>
                    <select class="form-control" id="category" name="category" required>
                        <option value="Pop" <?php echo $music['category'] === 'Pop' ? 'selected' : ''; ?>>Pop</option>
                        <option value="Rock" <?php echo $music['category'] === 'Rock' ? 'selected' : ''; ?>>Rock</option>
                        <option value="Jazz" <?php echo $music['category'] === 'Jazz' ? 'selected' : ''; ?>>Jazz</option>
                        <option value="Classical" <?php echo $music['category'] === 'Classical' ? 'selected' : ''; ?>>Classical</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="music_file">Music File</label>
                    <input type="file" class="form-control-file" name="music_file" id="music_file">
                    <small class="form-text text-muted">Leave blank to keep the current file.</small>
                </div>

                <button type="submit" name="update_music" class="btn btn-primary">Update Music</button>
                <a href="admin_dashboard.php" class="btn btn-outline-secondary ml-2">Cancel</a>
            </form>
            <?php else: ?>
            <p class="mb-0">Music file not found.</p>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
