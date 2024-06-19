<?php 
$con=mysqli_connect('localhost','root','','dbms');
// if(mysqli_connect_errno())
// {
// 	die("Connection error");
//  }
 if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
 ?>
