<?php
// update_user.php

$servername = "localhost";
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "vehicle_auction";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_POST['id'];
$username = $_POST['username'];
$email = $_POST['email'];
$mnumber = $_POST['mnumber'];
$sql = "UPDATE users SET username='$username', email='$email', mnumber='$mnumber' WHERE id=$id";
if (mysqli_query($conn, $sql)) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . mysqli_error($conn);
}
?>