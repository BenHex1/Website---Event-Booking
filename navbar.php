<?php
include_once 'conn.php';
?>

<nav class="navbar">
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="task1.php">Events</a></li>
        <li><a href="bookEventsForm.php">Book Now</a></li>
        <li><a href="credits.php">Credits</a></li>

        <?php if(loggedIn()) { ?>
            <li><a href="logout.php">Logout</a></li>
        <?php } else { ?>
            <li><a href="login.php">Login</a></li>
        <?php } ?>
    </ul>
</nav>