
<!DOCTYPE html>
<style>
    body {
    font-family: Arial, sans-serif;
    background-color: #f0f0f0;
    background-image:linear-gradient(rgba(0,0,0,0.5),rgba(0,0,0,0.5)), url(plan.jpg);
			height: 100vh;
			background-size: cover;
			background-position: center;
}

.container {
   
    width: 100%;
    max-width: 600px;
    border-radius: 8px;   
    margin: 50px auto;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 5px;
    box-shadow: 0 0 10px white;
    text-align: center;
    
   
}

h2 {
    color: #333;
}

p {
    margin-bottom: 10px;
}

a {
    display: inline-block;
    padding: 10px 20px;
    margin-top: 20px;
    background-color: #007bff;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

a:hover {
    background-color: #0056b3;
}

</style>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation</title>
    
</head>
<body>
    <div class="container">
        <h2>Booking Confirmation</h2>
        <?php
        // Check if booking ID is passed via URL parameter
        if (isset($_GET['booking_id'])) {
            $booking_id = $_GET['booking_id'];
            echo "<p>Your booking has been successfully completed!</p>";
            echo "<p>Your booking ID is: " . htmlspecialchars($booking_id) . "</p>";
            echo "<p>Thank you for choosing our airline.</p>";
        } else {
            echo "<p>Booking ID not found.</p>";
        }
        ?>
        
        <a href="dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>
