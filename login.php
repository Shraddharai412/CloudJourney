<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require 'dbconnection.php';

    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT `id`, `password` FROM users WHERE username = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $hashed_password);
    $stmt->fetch();

    if ($stmt->num_rows > 0 && password_verify($password, $hashed_password)) {
        $_SESSION['user_id'] = $id;
        header("Location: passengerchoice.html");
    } else {
        echo "Invalid username or password";
    }

    $stmt->close();
    $con->close();
}
?>
