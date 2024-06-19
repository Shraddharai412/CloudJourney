<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: logincu.html");
    exit();
}

require 'dbconnection.php';

$user_id = $_SESSION['user_id'];

// Adjust SQL statement to match your database schema
$sql = "SELECT b.id AS booking_id, f.FLIGHT_CODE, f.SOURCE, f.DESTINATION, f.DEPARTURE, f.ARRIVAL, f.DURATION, b.status 
        FROM bookings b 
        JOIN flight f ON b.flight_id = f.FLIGHT_CODE 
        WHERE b.user_id = ?";

$stmt = $con->prepare($sql);

if ($stmt === false) {
    die("Error preparing the SQL statement: " . $con->error);
}

$stmt->bind_param("i", $user_id);

if ($stmt->execute()) {
    $result = $stmt->get_result();
    $bookings = $result->fetch_all(MYSQLI_ASSOC);
} else {
    die("Error executing the SQL statement: " . $stmt->error);
}

$stmt->close();
$con->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Tickets</title>
    <style>
        body {
            background-image:linear-gradient(rgba(0,0,0,0.5),rgba(0,0,0,0.5)), url(plan.jpg);
			height: 100vh;
			background-size: cover;
			background-position: center;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 50px auto;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 0 10px white;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .button {
            display: block;
            width: 200px;
            text-align: center;
            padding: 10px;
            margin: 20px auto;
            background-color: #0275d8;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
        }

        .button:hover {
            background-color: #025aa5;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Your Bookings</h2>
        <?php if (count($bookings) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Booking ID</th>
                        <th>Flight Code</th>
                        <th>Source</th>
                        <th>Destination</th>
                        <th>Departure</th>
                        <th>Arrival</th>
                        <th>Duration</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bookings as $booking): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($booking['booking_id']); ?></td>
                            <td><?php echo htmlspecialchars($booking['FLIGHT_CODE']); ?></td>
                            <td><?php echo htmlspecialchars($booking['SOURCE']); ?></td>
                            <td><?php echo htmlspecialchars($booking['DESTINATION']); ?></td>
                            <td><?php echo htmlspecialchars($booking['DEPARTURE']); ?></td>
                            <td><?php echo htmlspecialchars($booking['ARRIVAL']); ?></td>
                            <td><?php echo htmlspecialchars($booking['DURATION']); ?></td>
                            <td><?php echo htmlspecialchars($booking['status']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No bookings found.</p>
        <?php endif; ?>
        <a href="dashboard.php" class="button">Back to Dashboard</a>
    </div>
</body>
</html>
