<?php
require_once('dbconnection.php'); 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    

    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $email = $_POST['email'];

    $sql = "INSERT INTO users (username, password, email) VALUES (?, ?, ?)";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("sss", $username, $password, $email);

    if ($stmt->execute()) {
        echo "Registration successful";
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }

    $stmt->close();
    $con->close();
}
?>

