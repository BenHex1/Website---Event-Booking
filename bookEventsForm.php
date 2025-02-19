
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Book events</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/kimeiga/bahunya/dist/bahunya.min.css">
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<?php include 'navbar.php'; ?>
<h1>Book events</h1>

<form id="bookingForm" action="javascript:alert('form submitted');" method="get">
	<section id="bookEvents">
		<h2>Select events</h2>
<?php
try {
	// include the file with the function for the database connection
	require_once('conn.php'); // My database connection code is in this file - not functions.php
	// get database connection
	$dbConn = getConnection();
	$sqlEvents = 'SELECT eventID, eventTitle, eventStartDate, eventEndDate, catDesc, venueName, eventPrice FROM EGN_events e INNER JOIN EGN_categories c ON e.catID = c.catID INNER JOIN EGN_venues v ON e.venueID = v.venueID ORDER BY eventTitle';

	// execute the query
	$rsEvents = $dbConn->query($sqlEvents);

	while ($event = $rsEvents->fetchObject()) {
		$eventTitle = $event->eventTitle;
		echo "\t<div class='item'>
				<span class='eventTitle'>".filter_var($eventTitle, FILTER_SANITIZE_SPECIAL_CHARS)."</span>
				<span class='eventStartDate'>{$event->eventStartDate}</span>
            	<span class='eventEndDate'>{$event->eventEndDate}</span>
	            <span class='catDesc'>{$event->catDesc}</span>
	         	<span class='venueName'>{$event->venueName}</span>
	            <span class='eventPrice'>{$event->eventPrice}</span>
	            <span class='chosen'><input class='chosen-input' type='checkbox' name='event[]' value='{$event->eventID}' data-price='{$event->eventPrice}'></span>
	      		</div>\n";
	}
}
catch (Exception $e) {
	echo "Problem " . $e->getMessage();
}
?>
	</section>
	<section id="collection">
			<h2>Collection method</h2>
			<p>Please select whether you want your chosen event ticket(s) to be delivered to your home address (a charge applies for this) or whether you want to collect them yourself.</p>
			<p>
			Home address - &pound;7.99 <input type="radio" name="deliveryType" value="home" data-price="7.99" checked>&nbsp; | &nbsp;
			Collect from ticket office - no charge <input type="radio" name="deliveryType" value="ticketOffice" data-price="0">
			</p>
	</section>
	<section id="checkCost">
		<h2>Total cost</h2>
		Total <input type="text" name="total" size="10" readonly value="0.00">
	</section>
	<section id="placeBooking">
		<h2>Place booking</h2>
		<h3>Your details</h3>
		<div id="custDetails" class="custDetails">
			Forename <input type="text" name="forename" id="forename">
			Surname <input type="text" name="surname" id="surname">
		</div>
		<p style="color: #FF0000; font-weight: bold;" id='termsText'>I have read and agree to the terms and conditions
		<input type="checkbox" name="termsChkbx" id="checkbox"></p>
		<p><input type="submit" name="submit" value="Book now!" id="submit" disabled></p>
	</section>
</form>
<!-- Here you need to add Javascript or a link to a script (.js file) to process the form as required for task 4 of the assignment -->
<script>
	const termsText = document.getElementById('termsText');
	const checkbox = document.getElementById('checkbox');
	const submitButton = document.getElementById('submit');

	// When the user clicks on the checkbox, remove the disabled attribute from the submit button
	checkbox.addEventListener('click', function() {
		if (checkbox.checked == true) {
			// Enable the Book Now button
			submitButton.removeAttribute('disabled');
			
			// Change the text colour and font weight
			termsText.style.color = '#FFF';
			termsText.style.fontWeight = 'normal';
		} else {
			// Disable the Book Now button
			submitButton.setAttribute('disabled', 'disabled');

			// Change the text colour and font weight
			termsText.style.color = '#FF0000';
			termsText.style.fontWeight = 'bold';
		}
	});

	// Validate the submission
	submitButton.addEventListener('click', function(event) {
		event.preventDefault();

		// Must have selected at least one event
		// Must enter a forename and surname

		const events = document.getElementsByClassName('chosen-input');
		const forename = document.getElementById('forename');
		const surname = document.getElementById('surname');

		let valid = true;

		// Check if at least one event is selected
		for (let i = 0; i < events.length; i++) {
			if (events[i].checked) {
				valid = true;
				break;
			} else {
				valid = false;
			}
		}

		// Check if forename and surname are entered
		if (forename.value == '' || surname.value == '') {
			valid = false;
		}

		// If valid, submit the form
		if (valid) {
			document.getElementById('bookingForm').submit();
		} else {
			alert('Please select at least one event and enter your forename and surname.');
		}
	});

	// Calculate the total cost
	const events = document.getElementsByClassName('chosen-input');

	// Add event listeners to each checkbox
	for (let i = 0; i < events.length; i++) {
		events[i].addEventListener('click', function() {
			let total = 0;

			// Calculate the total cost
			for (let i = 0; i < events.length; i++) {
				if (events[i].checked) {
					// Add the price of the event to the total
					total += parseFloat(events[i].getAttribute('data-price'));
				}
			}

			// Display the total cost and round to 2 decimal places
			document.getElementsByName('total')[0].value = total.toFixed(2);
		});
	}
</script>
</body>
</html>
