<?php
session_start(); // Start session

session_destroy(); // Destroy session

header("Location: index.php"); // Redirect to homepage
?>