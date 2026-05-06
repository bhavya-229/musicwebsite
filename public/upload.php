<?php
session_start();
require_once '../src/db.php';

$message = '';
$messageType = '';

if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = $_POST['title'];
        $file = $_FILES['file'];
        $author = $_POST['author'];
        $category = $_POST['category'];

        $targetDir = '../src/uploads/';
        $targetFilePath = $targetDir . basename($file['name']);
        $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

        $allowedTypes = ['mp3', 'wav', 'ogg'];
        if (in_array($fileType, $allowedTypes, true)) {
            if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
                $stmt = $pdo->prepare('INSERT INTO music (title, artist, category, file_path) VALUES (?, ?, ?, ?)');
                if ($stmt->execute([$title, $author, $category, 'uploads/' . $file['name']])) {
                    $message = 'Music uploaded successfully.';
                    $messageType = 'success';
                } else {
                    $message = 'Database insertion failed.';
                    $messageType = 'danger';
                }
            } else {
                $message = 'File upload failed.';
                $messageType = 'danger';
            }
        } else {
            $message = 'Invalid file format. Please upload mp3, wav, or ogg.';
            $messageType = 'danger';
        }
    }
} else {
    $message = 'Unauthorized access.';
    $messageType = 'danger';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Music</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <?php if (!empty($message)): ?>
    <div class="status-wrap">
        <div class="alert alert-<?php echo htmlspecialchars($messageType); ?> mt-3 mb-0" role="alert">
            <?php echo htmlspecialchars($message); ?>
        </div>
    </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
    <div class="card form-card">
        <div class="card-header">
            <h3 class="card-title">Upload Music</h3>
        </div>
        <div class="card-body">
            <form action="upload.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input id="title" type="text" name="title" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="author">Author</label>
                    <input id="author" type="text" name="author" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="category">Category</label>
                    <select class="form-control" id="category" name="category" required>
                        <option value="Pop">Pop</option>
                        <option value="Rock">Rock</option>
                        <option value="Jazz">Jazz</option>
                        <option value="Classical">Classical</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="file">Choose Music File</label>
                    <input id="file" type="file" name="file" class="form-control-file" accept="audio/*" required>
                </div>
                <button type="submit" class="btn btn-primary">Upload</button>
                <a href="admin_dashboard.php" class="btn btn-outline-secondary ml-2">Back to Dashboard</a>
            </form>
        </div>
    </div>
    <?php endif; ?>
</body>

</html>
