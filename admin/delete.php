<?php
// delete.php

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

$id = $_GET['id'];
$sql = "DELETE FROM users WHERE id = $id";
if (mysqli_query($conn, $sql)) {
    header('Location: admin_dashboard.php');
} else {
    echo "Error deleting record: " . mysqli_error($conn);
}
?>