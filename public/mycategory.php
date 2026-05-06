<?php
session_start();
require_once '../src/db.php';

$category = isset($_GET['category']) ? $_GET['category'] : null;

if ($category) {
    $stmt = $pdo->prepare('SELECT * FROM music WHERE category = ?');
    $stmt->execute([$category]);
    $musicFiles = $stmt->fetchAll();
} else {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($category); ?> Music</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <header class="site-header">
        <?php require_once '../template/header.php'; ?>
    </header>

    <main class="site-main container">
        <section class="hero text-center">
            <div class="container py-2">
                <h1><?php echo htmlspecialchars($category); ?> Music</h1>
                <p>Listen and download your favorite <?php echo htmlspecialchars($category); ?> tracks</p>
            </div>
        </section>

        <section class="mt-4">
            <?php if ($musicFiles): ?>
            <div id="musicList" class="row">
                <?php foreach ($musicFiles as $music): ?>
                <div class="col-md-4 mb-4">
                    <div class="music-card card h-100">
                        <div class="card-body d-flex flex-column">
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
            </div>
            <?php else: ?>
            <div class="alert alert-info" role="alert">
                No music files found in <?php echo htmlspecialchars($category); ?> category.
            </div>
            <?php endif; ?>
        </section>
    </main>

    <footer class="site-footer">
        <?php require_once '../template/footer.php'; ?>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
