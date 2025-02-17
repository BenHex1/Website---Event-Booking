<?php
include_once 'conn.php';

// Get username and password from POST request
$username = $_POST['username'];
$password = $_POST['password'];

// Validate
if (empty($username) || empty($password)) {
    header('Location: login.php?error=1');
}

// Get user from DB
$conn = getConnection();
$stmt = $conn->prepare("SELECT * FROM EGN_users WHERE username = :username");
$stmt->bindParam(':username', $username);
$stmt->execute();
$user = $stmt->fetch();

// Check if user exists
if ($user) {
    // Check if password hash matches using password verify
    if (password_verify($password, $user['passwordHash'])) {
        $_SESSION['user'] = array(
            'id' => $user['id'],
            'username' => $user['username'],
            'email' => $user['email']
        );

        // Redirect to index.php
        header('Location: index.php');
    } else {
        // Redirect to login.php with error message
        header('Location: login.php?error=1');
    }
} else {
    // Redirect to login.php with error message
    header('Location: login.php?error=1');
}
?>