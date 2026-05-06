<?php
session_start();
require_once '../src/db.php';

$stmt = $pdo->prepare('SELECT * FROM music');
$stmt->execute();
$musicFiles = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Music Website</title>
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
        <?php if (isset($_SESSION['username'])): ?>
        <nav class="navbar navbar-expand-lg navbar-light category-navbar">
            <a class="navbar-brand" href="#">Music Categories</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCategories"
                aria-controls="navbarCategories" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarCategories">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="mycategory.php?category=Pop">Pop</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="mycategory.php?category=Rock">Rock</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="mycategory.php?category=Jazz">Jazz</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="mycategory.php?category=Classical">Classical</a>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="search-bar">
            <input type="text" id="searchInput" class="form-control" placeholder="Search by title or artist...">
        </div>

        <div id="musicList" class="row">
            <?php foreach ($musicFiles as $music): ?>
            <div class="col-md-4 mb-4">
                <div class="music-card card h-100">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?php echo htmlspecialchars($music['title']); ?></h5>
                        <p class="card-text">Author: <?php echo htmlspecialchars($music['artist']); ?></p>
                        <div class="mt-auto d-flex justify-content-between align-items-center download">
                            <a href="../src/<?php echo htmlspecialchars($music['file_path']); ?>"
                                download="<?php echo htmlspecialchars($music['title']); ?>.mp3" class="btn btn-outline-info">
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
        <section class="guest-hero text-center">
            <div class="container">
                <h1 class="guest-hero-title">Welcome to MelodyMine</h1>
                <p class="guest-hero-text mx-auto">Discover fresh tracks, revisit classics, and keep your music library close.</p>
            </div>
        </section>
        <section class="info-section text-center">
            <div class="container">
                <h2>Explore, Listen, and Download Your Favorite Music</h2>
                <p>
                    Welcome to our music platform, your ultimate destination for discovering and enjoying music. We
                    offer a diverse library of tracks, featuring the latest chart-toppers, hidden gems, and timeless
                    classics from artists all over the world. Whether you're a fan of pop, rock, jazz, hip-hop, or
                    classical music, you'll find something to match your taste.
                </p>
                <p>
                    Our platform is designed for music lovers who want more than just a listening experience.
                    Explore new releases all in one place. We regularly update our library to bring you fresh tunes
                    that suit every mood and occasion.
                </p>
                <p>
                    To enjoy the full experience, create an account or log in. As a registered user, you'll unlock
                    exclusive features like:
                </p>
                <ul>
                    <li><strong>Full-Length Streaming:</strong> Listen to songs in their entirety.</li>
                    <li><strong>Download Music:</strong> Save your favorite tracks for offline listening.</li>
                </ul>
                <p class="alert alert-warning mt-4">
                    <strong>Note:</strong> To listen to and download music, please log in or create an account.
                </p>

                <div class="cta-group">
                    <a href="login.php" class="btn btn-info">Login to Start Listening</a>
                    <a href="register.php" class="btn btn-secondary">Sign Up Now</a>
                </div>
            </div>
        </section>
        <?php endif; ?>
    </main>

    <footer class="site-footer">
        <?php require_once '../template/footer.php'; ?>
    </footer>

    <script>
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            let query = this.value.toLowerCase();
            let musicCards = document.querySelectorAll('#musicList .music-card');

            musicCards.forEach(function(card) {
                let title = card.querySelector('.card-title').textContent.toLowerCase();
                let artist = card.querySelector('.card-text').textContent.toLowerCase();

                if (title.includes(query) || artist.includes(query)) {
                    card.parentElement.style.display = 'block';
                } else {
                    card.parentElement.style.display = 'none';
                }
            });
        });
    }
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
