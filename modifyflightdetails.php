<?php
require_once "dbconnection.php";

// Initialize counters and error messages
$count = 0;
$flag = 0;
$errors = [];

$query = mysqli_query($con, "SELECT * FROM selected");
$rows = mysqli_fetch_array($query);
$flight = $rows['FLIGHT_CODE'];

if (isset($_POST['submit'])) {
    // Debugging: Print received values
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";

    // Update DEPARTURE, ARRIVAL, DURATION
    if (!empty($_POST['departure']) && !empty($_POST['arrival']) && !empty($_POST['duration'])) {
        $departure = $_POST['departure'];
        $arrival = $_POST['arrival'];
        $duration = $_POST['duration'];

        $sql = "UPDATE flight SET DEPARTURE = '$departure', ARRIVAL = '$arrival', DURATION = '$duration' WHERE FLIGHT_CODE = '$flight'";
        if (mysqli_query($con, $sql)) {
            $count += 3;
        } else {
            $errors[] = 'Data Modification Failed for DEPARTURE, ARRIVAL, DURATION: ' . mysqli_error($con);
        }
    } else {
        $errors[] = 'Enter values for Departure, Arrival, and Duration.';
    }

    // Update PRICE_BUSINESS
    if (!empty($_POST['businessclass'])) {
        $businessclass = $_POST['businessclass'];
        $sql = "UPDATE flight SET `PRICE(BUSINESS)` = '$businessclass' WHERE FLIGHT_CODE = '$flight'";
        echo "<p>SQL: $sql</p>"; // Debugging: Print SQL query
        if (mysqli_query($con, $sql)) {
            $flag += 1;
        } else {
            $errors[] = 'Data Modification Failed for Business Class: ' . mysqli_error($con);
        }
    }

    // Update PRICE_ECONOMY
    if (!empty($_POST['economyclass'])) {
        $economyclass = $_POST['economyclass'];
        $sql = "UPDATE flight SET `PRICE(ECONOMY)` = '$economyclass' WHERE FLIGHT_CODE = '$flight'";
        echo "<p>SQL: $sql</p>"; // Debugging: Print SQL query
        if (mysqli_query($con, $sql)) {
            $flag += 1;
        } else {
            $errors[] = 'Data Modification Failed for Economy Class: ' . mysqli_error($con);
        }
    }

    // Update PRICE_STUDENT
    if (!empty($_POST['students'])) {
        $students = $_POST['students'];
        $sql = "UPDATE flight SET `PRICE(STUDENT)` = '$students' WHERE FLIGHT_CODE = '$flight'";
        echo "<p>SQL: $sql</p>"; // Debugging: Print SQL query
        if (mysqli_query($con, $sql)) {
            $flag += 1;
        } else {
            $errors[] = 'Data Modification Failed for Student Class: ' . mysqli_error($con);
        }
    }

    // Update PRICE_DIFF
    if (!empty($_POST['diff'])) {
        $diff = $_POST['diff'];
        $sql = "UPDATE flight SET `PRICE(DIFF)`= '$diff' WHERE FLIGHT_CODE = '$flight'";
        echo "<p>SQL: $sql</p>"; // Debugging: Print SQL query
        if (mysqli_query($con, $sql)) {
            $flag += 1;
        } else {
            $errors[] = 'Data Modification Failed for Diff Class: ' . mysqli_error($con);
        }
    }

    // Delete from selected table
    $sql1 = "DELETE FROM selected WHERE FLIGHT_CODE = '$flight'";
    if (!mysqli_query($con, $sql1)) {
        $errors[] = 'Failed to delete from selected: ' . mysqli_error($con);
    }

    // Final feedback
    if ($count == 3 || $flag != 0) {
		echo "<script>alert('Data Modified Successfully')</script>";
        echo "<script>window.location='homepage.html'</script>";
    } else {
        $errors[] = 'Data Modification Failed';
    }

    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<script>alert('$error')</script>";
        }
        echo "<script>window.location='modifyadmindetails.html'</script>";
    }
}
?>
       

