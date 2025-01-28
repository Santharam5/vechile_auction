<?php
// update_auction.php
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
$title = $_POST['title'];
$current_bid = $_POST['current_bid'];
$sql = "UPDATE auctions SET title='$title', current_bid='$current_bid' WHERE id=$id";
if (mysqli_query($conn, $sql)) {
    echo "Auction updated successfully";
} else {
    echo "Error updating auction: " . mysqli_error($conn);
}
?>