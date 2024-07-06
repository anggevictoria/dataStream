<?php
session_start(); // Start the session

// Check if the user is not logged in
if (!isset($_SESSION['user_id']) || !$_SESSION['loggedin']) {
    // Redirect to the login page or another appropriate page
    header("Location: ../index.html"); // Adjust the path as needed
    exit; // Ensure no further code execution after redirection
}
?>
