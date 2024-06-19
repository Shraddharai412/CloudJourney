<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: logincu.html");
    exit();
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require 'dbconnection.php';

    $user_id = $_SESSION['user_id'];
    $booking_id = $_POST['booking_id'];

    // Check if booking exists and belongs to the user
    $sql = "SELECT * FROM bookings WHERE id = ? AND user_id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ii", $booking_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $booking = $result->fetch_assoc();

    if ($booking) {
        // Update booking status to 'Cancelled'
        $sql = "UPDATE bookings SET status = 'Cancelled' WHERE id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $booking_id);
        if ($stmt->execute()) {
            $message = "Booking ID " . htmlspecialchars($booking_id) . " has been cancelled.";
        } else {
            $message = "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $message = "Booking not found or does not belong to you.";
    }

    $con->close();
}
?>
<!DOCTYPE html>
<html>
    <style>
        body {
            background-image:linear-gradient(rgba(0,0,0,0.5),rgba(0,0,0,0.5)), url(plan.jpg);
	height: 100vh;
    background-size: cover;
	background-position: center;
    padding: 0;
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

.container {
    width: 50%;
    margin: 50px auto;
    padding: 20px;
    border-radius: 15px;
    box-shadow: 0 0 10px white;
}

h2 {
    text-align: center;
    color: #333;
}

form {
    display: flex;
    flex-direction: column;
    align-items: center;
}

label {
    margin-top: 10px;
    color: #555;
}

input[type="text"] {
    width: 80%;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 4px;
}

button {
    width: 50%;
    padding: 10px;
    background-color: #5cb85c;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin-top: 20px;
}

button:hover {
    background-color: #4cae4c;
}

a.button {
    display: block;
    width: 50%;
    text-align: center;
    padding: 10px;
    margin: 20px auto;
    background-color: #0275d8;
    color: #fff;
    text-decoration: none;
    border-radius: 4px;
}

a.button:hover {
    background-color: #025aa5;
}

.message {
    text-align: center;
    padding: 10px;
    background-color: #dff0d8;
    color: #3c763d;
    border: 1px solid #d6e9c6;
    border-radius: 4px;
    margin-bottom: 20px;
}

    </style>
<head>
    <title>Cancel Booking</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Cancel Booking</h2>
        <?php if (!empty($message)): ?>
            <p class="message"><?php echo $message; ?></p>
        <?php endif; ?>
        <a href="dashboard.php" class="button">Back to Dashboard</a>
    </div>
</body>
</html>

