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
<nav>
    <?php include 'navbar.php'; ?>
    
    <header class="homeHeader">
        <h1>Update Successful</h1>
    </header>
    <main>
        <div>
            <?php
            include_once 'conn.php'; // Include your connection script

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Retrieve data from POST request
                $errors = [];

                $eventID = isset($_POST['eventID']) ? trim($_POST['eventID']) : '';
                if (empty($eventID) || !is_numeric($eventID)) {
                    $errors[] = "Invalid Event ID.";
                }
            
                $eventTitle = isset($_POST['eventTitle']) ? trim($_POST['eventTitle']) : '';
                if (empty($eventTitle)) {
                    $errors[] = "Event Title is required.";
                }
            
                $eventDescription = isset($_POST['eventDescription']) ? trim($_POST['eventDescription']) : '';
                // Additional validation for eventDescription if necessary
            
                $venueID = isset($_POST['venueID']) ? trim($_POST['venueID']) : '';
                if (empty($venueID)) {
                    $errors[] = "Invalid Venue ID.";
                }
            
                $catID = isset($_POST['catID']) ? trim($_POST['catID']) : '';
                if (empty($catID)) {
                    $errors[] = "Invalid Category ID.";
                }
            
                $eventStartDate = isset($_POST['eventStartDate']) ? trim($_POST['eventStartDate']) : '';
                if (!validateDate($eventStartDate)) {
                    $errors[] = "Invalid Start Date.";
                }
            
                $eventEndDate = isset($_POST['eventEndDate']) ? trim($_POST['eventEndDate']) : '';
                if (!validateDate($eventEndDate)) {
                    $errors[] = "Invalid End Date.";
                }
            
                $eventPrice = isset($_POST['eventPrice']) ? trim($_POST['eventPrice']) : '';
                if (!is_numeric($eventPrice)) {
                    $errors[] = "Invalid Event Price.";
                }

                if (count($errors) == 0){
                    $conn = getConnection();

                    try {
                        // Prepare the SQL Update statement
                        $stmt = $conn->prepare("
                            UPDATE EGN_events 
                            SET eventTitle = :eventTitle, 
                                eventDescription = :eventDescription, 
                                venueID = :venueID, 
                                catID = :catID, 
                                eventStartDate = :eventStartDate, 
                                eventEndDate = :eventEndDate, 
                                eventPrice = :eventPrice
                            WHERE eventID = :eventID
                        ");
    
                        // Bind parameters
                        $stmt->bindParam(':eventID', $eventID, PDO::PARAM_INT);
                        $stmt->bindParam(':eventTitle', $eventTitle);
                        $stmt->bindParam(':eventDescription', $eventDescription);
                        $stmt->bindParam(':venueID', $venueID);
                        $stmt->bindParam(':catID', $catID);
                        $stmt->bindParam(':eventStartDate', $eventStartDate);
                        $stmt->bindParam(':eventEndDate', $eventEndDate);
                        $stmt->bindParam(':eventPrice', $eventPrice);
    
                        // Execute the statement
                        $stmt->execute();
    
                        // Redirect or inform the user of success
                        echo "Event updated successfully.";
                        
                    }catch (PDOException $e) {
                        echo "Database error: " . $e->getMessage();
                    }
                } else {
                    // Display validation errors
                    foreach ($errors as $error) {
                        echo "<p>$error</p>";
                    }
                }
            } else {
                echo "Invalid request method.";
            }
            
            // Function to validate date format
            function validateDate($date, $format = 'Y-m-d') {
                $d = DateTime::createFromFormat($format, $date);
                return $d && $d->format($format) === $date;
            }
            ?>       
        </div>
    </main>
</body>
</html>