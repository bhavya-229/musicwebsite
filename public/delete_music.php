<?php
session_start();

// Only allow admin to access this page
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

require_once '../src/db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Retrieve the music file to delete the associated file from the server
    $stmt = $pdo->prepare("SELECT * FROM music WHERE id = ?");
    $stmt->execute([$id]);
    $music = $stmt->fetch();

    if ($music) {
        // Delete the music file from the server
        $file_path = '../src/' . $music['file_path'];
        if (file_exists($file_path)) {
            unlink($file_path); // Delete the file
        }

        // Delete the record from the database
        $stmt = $pdo->prepare("DELETE FROM music WHERE id = ?");
        $stmt->execute([$id]);
        
        header("Location: admin_dashboard.php");
        exit();
    } else {
        echo "Music file not found.";
    }
} else {
    echo "No music file ID provided.";
}
?>
