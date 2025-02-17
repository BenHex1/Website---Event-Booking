<?php
include_once 'conn.php'; 
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EGN editEvent</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/kimeiga/bahunya/dist/bahunya.min.css">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <header class="homeHeader">
        <h1>Login</h1>
    </header>
    <?php
        if(isset($_GET['error'])){
            echo "Incorrect username or password";
        }
    ?>
    <main>
        <form action="loginSubmit.php" method="post">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" required>
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>
            <input type="submit" value="Login">
        </form>
    </main>
</body>
</html>