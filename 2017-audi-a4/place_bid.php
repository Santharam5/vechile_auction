<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the email, vehicle name, and bid amount from the form
    $email = $_POST['email'];
    $vehicle_name = $_POST['vehicle_name'];
    $bid_amount = $_POST['bid_amount'];

    // Validate the input
    if (empty($email) || empty($vehicle_name) || empty($bid_amount)) {
        die('Email, vehicle name, and bid amount are required.');
    }

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

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO bids (email, vehicle_name, bid_amount) VALUES (?, ?, ?)");
    $stmt->bind_param("ssd", $email, $vehicle_name, $bid_amount);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Bid placed successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();

    // Redirect to a confirmation page or back to the bidding page
    header("Location: confirmation.php");
    exit();
} else {
    die('Invalid request method.');
}
?>