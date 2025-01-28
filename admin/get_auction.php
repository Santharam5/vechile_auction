<?php
// get_auction.php
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
$sql = "SELECT * FROM auctions WHERE id = $id";
$result = mysqli_query($conn, $sql);
$auction = mysqli_fetch_assoc($result);
echo json_encode($auction);
?>