 <?php
require 'dbconnection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $origin = $_POST['origin'];
    $destination = $_POST['destination'];
    $departure_date = $_POST['departure_date'];

    // SQL query adjusted to your table schema
    $sql = "SELECT * FROM flight WHERE SOURCE = ? AND DESTINATION = ? AND DATE = ?";
    $stmt = $con->prepare($sql);

    // Check if the statement was prepared successfully
    if ($stmt === false) {
        die("Error preparing the SQL statement: " . $con->error);
    }

    // Bind parameters to the query
    $stmt->bind_param("sss", $origin, $destination, $departure_date);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $flights = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
    } else {
        die("Error executing the SQL statement: " . $stmt->error);
    }

    $con->close();
}
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
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
    padding: 20px;
    background-image:linear-gradient(rgba(0,0,0,0.5),rgba(0,0,0,0.5)), url(plan.jpg);
			height: 100vh;
			background-size: cover;
			background-position: center;
}

/* Form container styles */
form {
   color: purple;
    padding: 20px;
    width: 100%;
    max-width: 400px;
    border-radius: 8px;
   
    margin-bottom: 20px;
}

/* Heading styles */
h2 {
    text-align: center;
    margin-bottom: 20px;
    color: white;
    
}

/* Label styles */
label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
    color: blue;
}

/* Input field styles */
input[type="text"],
input[type="date"] {
    width: calc(100% - 22px); /* Adjust for padding and border */
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

/* Button styles */
button {
    width: 100%;
    padding: 10px;
    background-color: #4CAF50;
    color:black;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
}

button:hover {
    background-color: #45a049;
}

/* Input focus styles */
input[type="text"]:focus,
input[type="date"]:focus {
    outline: none;
    border-color: #4CAF50;
    box-shadow: 0 0 5px #4CAF50;
}

/* Form container spacing */
form > *:not(:last-child) {
    margin-bottom: 15px;
}

/* Link styles */
a {
    display: block;
    margin-top: 20px;
    text-align: center;
    color:black;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}

/* Search results heading styles */
h1 {
    color: white;
    margin-bottom: 20px;
}

/* No flights found message styles */
p {
    color: green;
}
/* Button styles for Book Now */
button[type="submit"] {
    background-color: #007BFF;
    color: white;
    border: none;
    padding: 8px 12px;
    cursor: pointer;
    border-radius: 4px;
    transition: background-color 0.3s ease;
    display: inline-block; /* Display as inline block */
    width: auto; /* Automatically adjusts width based on content */
    text-align: center;
    font-size: 14px;
    position:relative;
    
}

button[type="submit"]:hover {
    background-color: #0056b3;
}


/* Container styles for flight search results */
ul {
    list-style-type: none;
    padding: 0;
}

ul li {
    background-color: #fff;
    margin-bottom: 20px;
    padding: 25px;
    border-radius: 4px;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    color: blue;
}
    </style>
<head>
    <title>Search Results</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <h2>Flight Search Results</h2>
    <?php if (isset($flights) && count($flights) > 0): ?>
        <ul>
            <?php foreach ($flights as $flight): ?>
                <li>
                    Flight Code: <?php echo htmlspecialchars($flight['FLIGHT_CODE']); ?>, 
                    Source: <?php echo htmlspecialchars($flight['SOURCE']); ?>, 
                    Destination: <?php echo htmlspecialchars($flight['DESTINATION']); ?>, 
                    Departure: <?php echo htmlspecialchars($flight['DEPARTURE']); ?>, 
                    Arrival: <?php echo htmlspecialchars($flight['ARRIVAL']); ?>, 
                    Duration: <?php echo htmlspecialchars($flight['DURATION']); ?>, 
                    Price (Business): $<?php echo htmlspecialchars($flight['PRICE(BUSINESS)']); ?>, 
                    Price (Economy): $<?php echo htmlspecialchars($flight['PRICE(ECONOMY)']); ?>, 
                    Price (Student): $<?php echo htmlspecialchars($flight['PRICE(STUDENT)']); ?>, 
                    Price Difference: $<?php echo htmlspecialchars($flight['PRICE(DIFF)']); ?>

                    <!-- Book Now button/link -->
                    <form action="book_flight.php" method="POST" style="display:inline;">
                        <input type="hidden" name="flight_id" value="<?php echo htmlspecialchars($flight['FLIGHT_CODE']); ?>">
                        <button type="submit">Book Now</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No flights found for your search criteria.</p>
    <?php endif; ?>
</body>
</html>
