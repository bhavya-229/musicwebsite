<?php
require_once '../src/db.php';

$stmt = $pdo->prepare('SELECT * FROM music ');
$stmt->execute();
$musicFiles = $stmt->fetchAll();

if ($musicFiles):
?>
<div class="container mt-4">
    <div class="row">
        <div class="col">
            <h3 class="text-center">Music List</h3>
            <div class="card-deck">
                <?php foreach ($musicFiles as $music): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><?php echo htmlspecialchars($music['title']); ?></h5>
                                <p class="card-text"><strong>Author:</strong> <?php echo htmlspecialchars($music['artist']); ?></p>
                                <audio controls class="mt-auto">
                                    <source src="../src/uploads/<?php echo htmlspecialchars($music['file_path']); ?>" type="audio/<?php echo pathinfo($music['file_path'], PATHINFO_EXTENSION); ?>">
                                    Your browser does not support the audio element.
                                </audio>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<?php
else:
    echo '<div class="alert alert-info" role="alert">No music files found</div>';
endif;
?>
