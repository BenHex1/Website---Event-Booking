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
        <h1>Editing Event</h1>
    </header>
    <main>
        <div>
            <?php
            include_once 'conn.php'; // Connect to the database

            // Ensure user is logged in
            if(!loggedIn()) {
                header("Location: login.php?error=2");
            }

            // Check if the 'id' GET parameter is set
            if(isset($_GET['id'])) {
                $eventID = $_GET['id']; // Get the event ID from the URL

                try {
                    // Get PDO connection
                    $conn = getConnection();

                    // Fetch all venues
                    $venueStmt = $conn->query("SELECT venueID, venueName FROM EGN_venues");
                    $venues = $venueStmt->fetchAll(PDO::FETCH_ASSOC);

                    // Fetch all categories
                    $categoryStmt = $conn->query("SELECT catID, catDesc FROM EGN_categories");
                    $categories = $categoryStmt->fetchAll(PDO::FETCH_ASSOC);

                    // Prepare the SQL query
                    $stmt = $conn->prepare("
                    SELECT E.*, V.venueName, C.catDesc 
                    FROM EGN_events E
                    LEFT JOIN EGN_venues V ON E.venueID = V.venueID
                    LEFT JOIN EGN_categories C ON E.catID = C.catID
                    WHERE E.eventID = :eventID
                    ");
                    $stmt->bindParam(':eventID', $eventID, PDO::PARAM_INT);

                    // Execute the statement
                    $stmt->execute();

                    // Fetch the event data
                    $event = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($event) {
                        ?>
                        <form action="updateEvent.php" method="post">
                        <input type="hidden" name="eventID" value="<?php echo htmlspecialchars($event['eventID']); ?>">
                            Event Name: <input type="text" name="eventTitle" value="<?php echo htmlspecialchars($event['eventTitle']); ?>"><br>
                            Event Description: <textarea name="eventDescription"><?php echo htmlspecialchars($event['eventDescription']); ?></textarea><br>
                            Venue: <select name="venueID">
                                <?php foreach ($venues as $venue) {
                                $selected = $event['venueID'] == $venue['venueID'] ? 'selected' : '';
                                echo "<option value='" . $venue['venueID'] . "' $selected>" . htmlspecialchars($venue['venueName']) . "</option>";
                                } ?> </select><br>
                            Category: <select name="catID">
                                <?php foreach ($categories as $category) {
                                $selected = $event['catID'] == $category['catID'] ? 'selected' : '';
                                echo "<option value='" . $category['catID'] . "' $selected>" . htmlspecialchars($category['catDesc']) . "</option>";
                                } ?> </select><br>
                            Start Date: <input type="date" name="eventStartDate" value="<?php echo htmlspecialchars($event['eventStartDate']); ?>"><br>
                            End Date: <input type="date" name="eventEndDate" value="<?php echo htmlspecialchars($event['eventEndDate']); ?>"><br>
                            Price: <input type="text" name="eventPrice" value="<?php echo htmlspecialchars($event['eventPrice']); ?>"><br>
                            <input type="submit" value="Update Event">
                        </form>
                        <?php
                    } else {
                        echo "No event found with ID: $eventID";
                    }
                } catch (PDOException $e) {
                    echo "Database error: " . $e->getMessage();
                }
            } else {
                echo "No event ID specified.";
            }
            ?>
        </div>
    </main>
</body>
</html>