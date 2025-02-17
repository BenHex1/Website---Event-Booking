<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EGN Homepage</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/kimeiga/bahunya/dist/bahunya.min.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    
    <header class="homeHeader">
        <h1>Events Guide North (EGN)</h1>
    </header>
    <main>
        <aside id="offers"></aside>
        <h5>About us:</h5>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus fermentum sollicitudin nisi eu maximus. Curabitur molestie lacus ut sollicitudin congue. Mauris egestas nibh eget molestie lacinia. Phasellus consequat sit amet risus non gravida. Nunc eleifend aliquet faucibus. Duis nec porttitor risus, at fringilla risus. Nunc consectetur pharetra vulputate. Nulla sodales, nisi a egestas malesuada, odio enim malesuada enim, et condimentum nisi nibh eget ex. </p>
    </main>

    <script>
        // Function to fetch and display special offer
        function loadSpecialOffer() {
            fetch('getOffers.php')
                .then(response => response.json())
                .then(data => {
                    var offerContent = "<h2>Special Offer</h2>";
                    offerContent += "<h5>Title: " + data.eventTitle + "</h5>";
                    offerContent += "<p>Category: " + data.catDesc + "</p>";
                    offerContent += "<p>Price: £" + data.eventPrice + "</p>";
                    document.getElementById('offers').innerHTML = offerContent;
                })
                .catch(error => console.error('Error fetching offer:', error));
        }

        // Load special offer when the page loads
        loadSpecialOffer();

        // Refresh the special offer every 5 seconds (5000 milliseconds)
        setInterval(loadSpecialOffer, 5000);
    </script>
    
</body>
</html>