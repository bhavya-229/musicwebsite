<?php
session_start();
require_once '../src/db.php'; // Include your database connection file

// Get the selected category from the URL
$category = isset($_GET['category']) ? $_GET['category'] : null;

if ($category) {
    // Prepare and execute the query to fetch music by category
    $stmt = $pdo->prepare('SELECT * FROM music WHERE category = ?');
    $stmt->execute([$category]);
    $musicFiles = $stmt->fetchAll();
} else {
    // If no category is selected, you can either redirect or show all music
    header("Location: index.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($category); ?> Music</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>

    <header>
        <?php require_once '../template/header.php'; ?>
    </header>

    <section class="hero">
        <div class="container text-center py-5">
            <h1><?php echo htmlspecialchars($category); ?> Music</h1>
            <p>Listen and download your favorite <?php echo htmlspecialchars($category); ?> tracks</p>
        </div>
    </section>

    <main class="content container mt-5">
        <?php if ($musicFiles): ?>
        
           
            <div id="musicList" class="row">

            <?php foreach ($musicFiles as $music): ?>
            <div class="col-md-4 mb-4">
                <div class="music-card card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($music['title']); ?></h5>
                        <p class="card-text">Author: <?php echo htmlspecialchars($music['artist']); ?></p>
                        <div class="mt-auto d-flex justify-content-between align-items-center download">
                            <a href="../src/<?php echo htmlspecialchars($music['file_path']); ?>"
                                download="<?php echo htmlspecialchars($music['title']); ?>.mp3"
                                class="btn btn-outline-info">
                                Download
                            </a>
                        </div>
                        <audio controls>
                            <source src="../src/<?php echo htmlspecialchars($music['file_path']); ?>"
                                type="audio/<?php echo pathinfo($music['file_path'], PATHINFO_EXTENSION); ?>">
                            Your browser does not support the audio element.
                        </audio>
                    </div>
                </div>
            </div>
                    <?php endforeach; ?>
                </ul>
            </div>
        
        <?php else: ?>
        <div class="alert alert-info" role="alert">No music files found in <?php echo htmlspecialchars($category); ?>
            category</div>
        <?php endif; ?>
    </main>

    <footer class="footer bg-darkgray text-light py-1">
        <?php require_once '../template/footer.php'; ?>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>