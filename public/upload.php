<?php
session_start();
require_once '../src/db.php';

if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $title = $_POST['title'];
        $file = $_FILES['file'];
        $Author = $_POST['author'];
        $category = $_POST['category'];                 
        // File upload path
        $targetDir = "../src/uploads/";
        $targetFilePath = $targetDir . basename($file["name"]);
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        // Allow certain file formats
        $allowedTypes = array('mp3', 'wav', 'ogg');
        if (in_array($fileType, $allowedTypes)) {
            // Upload file to server
            if (move_uploaded_file($file["tmp_name"], $targetFilePath)) {
                // Insert into database
            
                $stmt = $pdo->prepare('INSERT INTO music (title,artist,category, file_path) VALUES ( ? ,?,?, ?)');
                if ($stmt->execute([$title,$Author,$category, "uploads/".$file["name"]])) {
                    echo '<div class="alert alert-success" role="alert">Music uploaded successfully</div>';
                } else {
                    echo '<div class="alert alert-danger" role="alert">Database insertion failed</div>';
                }
            } else {
                echo '<div class="alert alert-danger" role="alert">File upload failed</div>';
            }
        } else {
            echo '<div class="alert alert-danger" role="alert">Invalid file format</div>';
        }
    }
} else {
    echo '<div class="alert alert-danger" role="alert">Unauthorized access</div>';
}
?>
<html>

<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>

    <?php
if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin'):
    ?>
    <div class="card mb-4 mt-5" style="align-self: center;width: 600px;">
        <div class="card-header">
            <h3 class="card-title">Upload Music</h3>
        </div>
        <div class="card-body">
            <form action="upload.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="title">Title:</label>
                    <input type="text" name="title" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="title">Author:</label>
                    <input type="text" name="author" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="category">Category</label>
                    <select class="form-control" id="category" name="category" required>
                        <option value="Pop">Pop</option>
                        <option value="Rock">Rock</option>
                        <option value="Jazz">Jazz</option>
                        <option value="Classical">Classical</option>
                        <!-- Add more categories as needed -->
                    </select>
                </div>
                <div class="form-group">
                    <label for="file">Choose Music File:</label>
                    <input type="file" name="file" class="form-control-file" accept="audio/*" required>
                </div>
                <button type="submit" class="btn btn-primary">Upload</button>
            </form>
        </div>
    </div>
    <?php
endif;
?>


</body>

</html>