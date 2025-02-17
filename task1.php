<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EGN Events</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/kimeiga/bahunya/dist/bahunya.min.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    
    <header class="homeHeader">
        <h1>EGN Event List</h1>
    </header>
    <main>
        <h2>
            Below is a list of all events in the database
        </h2>
        <h5>
            Please click the name of the event you want to edit:
        </h5>
        <div>
            <?php
            include_once 'conn.php'; // Connect to the database

            try {
                // Get PDO connection
                $conn = getConnection();

                // Prepare and execute the SQL query
                $stmt = $conn->prepare("
                SELECT E.eventID, E.eventTitle, E.eventStartDate, E.eventEndDate, E.eventPrice, V.venueName, C.catDesc 
                FROM EGN_events E
                LEFT JOIN EGN_venues V ON E.venueID = V.venueID
                LEFT JOIN EGN_categories C ON E.catID = C.catID
                ");
                $stmt->execute();

                // Fetch all events
                $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if (count($events) > 0) {
                    foreach ($events as $row) {
                        echo "<p>";
                        echo "<a href='editValue.php?id=" . $row['eventID'] . "'>" . htmlspecialchars($row['eventTitle']) . "</a><br>";
                        echo "Venue: " . htmlspecialchars($row['venueName']) . "<br>";
                        echo "Category: " . htmlspecialchars($row['catDesc']) . "<br>";
                        echo "Start Date: " . htmlspecialchars($row['eventStartDate']) . "<br>";
                        echo "End Date: " . htmlspecialchars($row['eventEndDate']) . "<br>";
                        echo "Price: £" . htmlspecialchars($row['eventPrice']) . "<br>";
                        echo "</p>";
                    }
                } else {
                    echo "<p>No events found.</p>";
                }
            } catch (PDOException $e) {
                echo "Database error: " . $e->getMessage();
            }
            ?>
        </div>
    </main>
</body>
</html
