<?php
session_start();
session_unset(); // Unset all of the session variables.
session_destroy(); // Destroy the session.

// Redirect to the homepage or login page
header("Location: index.php");
exit();
?>
