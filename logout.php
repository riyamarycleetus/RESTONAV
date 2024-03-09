<?php
session_start(); // Start the session

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    // If the user is logged in, destroy the session
    session_destroy();

    // Redirect the user to the home page or wherever you want after logout
    header("Location: home.html");
    exit();
} else {
    // If the user is not logged in, you can redirect them to the home page as well
    header("Location: home.html");
    exit();
}
?>
