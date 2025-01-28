<?php
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
$email = $_POST['email'];
$bid_amount = $_POST['bid_amount'];
$created_at = $_POST['created_at'];
$vehicle_name = $_POST['vehicle_name'];

$query = "UPDATE bids SET email = '$email', bid_amount = '$bid_amount', created_at = '$created_at', vehicle_name = '$vehicle_name' WHERE id = $id";

$response = array();

if (mysqli_query($conn, $query)) {
    $response['success'] = true;
} else {
    $response['success'] = false;
    $response['error'] = mysqli_error($conn);
}

// Set the content type to JSON and return the response
header('Content-Type: application/json');
echo json_encode($response);
?>