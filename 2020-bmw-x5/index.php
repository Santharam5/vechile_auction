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

// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: http://localhost/Auction_System/login.php");
    exit();
}

// Retrieve the email from the session
$email = $_SESSION['email'];

// Query the database to get the username and profile picture
$query = "SELECT username, profilepic FROM users WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$username = $user['username'];
$profilePic = $user['profilepic'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>2015 Ford Mustang - Bidding Page</title>
    <link rel="stylesheet" href="styles.css">
    <script src="scripts.js" defer></script>
    <style>
        .welcome-section {
            position: absolute;
            top: 0px;
            /* Adjusted to account for the navbar */
            left: 850px;
            margin: 10px;
            width: 500px;
            height: 150px;
        }

        .profile-container {
            display: flex;
            align-items: center;
        }

        .profile-pic {
            border-radius: 50%;
            width: 40px;
            height: 40px;
            margin-right: 10px;
            border: 2px solid white;
            /* Added white outline */
        }

        .welcome-message {
            color: white;
            font-size: 19px;
            font-weight: bold;

        }

        .welcome-iframe {
            width: 50px;
            height: 50px;
            border: none;
        }
    </style>
</head>

<body>
    <header>
        <nav>
            <div class="logo">AuctionPro</div>
            <ul>
                <li><a href="http://localhost/Auction_System/user_profile.php#home">Home</a></li>
                <li><a href="http://localhost/Auction_System/user_profile_info.php">Profile</a></li>
                <li><a href="http://localhost/Auction_System/user_bids.php">My bids</a></li>
                <li><a href="http://localhost/Auction_System/logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <div class="welcome-section">
        <div class="profile-container">

            <div class="welcome-message">Welcome, <?php echo $username; ?>!</div>
            <iframe src="https://lottie.host/embed/02cbc03e-d8ad-4e58-af0d-49d7943c68ea/osDEC71fov.json"
                class="welcome-iframe"></iframe>
        </div>
    </div>

    

    <section id="bidding-page">
        <div class="vehicle-details">
            <img src="./bmw.jpg" alt="2015 Ford Mustang">
            <h1>2020 BMW X5</h1>
            <p>Current Bid: $55,000</p>
            <form id="bid-form" method="POST" action="place_bid.php">
                <input type="hidden" name="email" value="<?php echo $email; ?>">
                <input type="hidden" name="vehicle_name" value="2020 BMW X5">
                <input type="number" name="bid_amount" placeholder="Enter your bid" required>
                <button type="submit">Place Bid</button>
            </form>
        </div>
    </section>

    <footer>
        <p>&copy; 2023 AuctionPro. All rights reserved.</p>
    </footer>
</body>

</html>