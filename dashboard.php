<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: logincu.html");
    exit();
}

require 'dbconnection.php';

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM bookings WHERE user_id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$bookings = $result->fetch_all(MYSQLI_ASSOC);

$stmt->close();
$con->close();
?>

<!DOCTYPE html>
<html>
    <style>
        /* Reset default styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Body styles */
body {
    font-family: Arial, sans-serif;
    background-color: #f0f0f0;
    display: flex;
    background-image:linear-gradient(rgba(0,0,0,0.5),rgba(0,0,0,0.5)), url(plan.jpg);
			height: 100vh;
			background-size: cover;
			background-position: center;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
    padding: 20px;
}

/* Container for the dashboard */
.container {
    
    padding: 20px;
    width: 100%;
    max-width: 600px;
    border-radius: 8px;
    box-shadow: 0 0 10px white;
}

/* Heading styles */
h2, h3 {
    text-align: center;
    margin-bottom: 20px;
}

/* List of bookings */
ul {
    list-style-type: none;
    padding: 0;
}

ul li {
    background-color: #fafafa;
    padding: 15px;
    margin-bottom: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

/* Button styles */
button, a.button {
    display: inline-block;
    padding: 10px 20px;
    background-color: #4CAF50;
    color: white;
    text-decoration: none;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    text-align: center;
}

button:hover, a.button:hover {
    background-color: #45a049;
}

/* Logout link styles */
a.logout {
    display: inline-block;
    margin-top: 20px;
    text-align: center;
    color: #4CAF50;
    text-decoration: none;
}

a.logout:hover {
    color: #45a049;
}

    </style>

<head>
    <title>Dashboard</title>
</head>
<body>
    <div class="container">
        <h2>Welcome to your dashboard</h2>
        <h3>Your Bookings:</h3>
        <ul>
            <?php foreach ($bookings as $booking): ?>
                <li>
                    <span>Booking ID: <?php echo $booking['id']; ?></span>
                    <span>Status: <?php echo $booking['status']; ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
        <a href="logout.php" class="logout">Logout</a>
    </div>
</body>
</html>
