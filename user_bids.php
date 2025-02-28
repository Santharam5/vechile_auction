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

// Fetch user's bids
$sql = "SELECT bid_amount, vehicle_name, created_at FROM bids WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

$bids = [];
while ($row = $result->fetch_assoc()) {
    $bids[] = $row;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>2015 Ford Mustang - Bidding Page</title>
    <link rel="stylesheet" href="css/bids.css">
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

        <style>body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 100%;
            width: 100%;
            animation: fadeIn 1s ease-in-out;
        }

        .left-side {
            flex: 3;
            /* Ensure this takes up more space */
            padding-right: 20px;
            height: 80vh;
            /* Ensure it takes the full viewport height */
        }

        .left-side iframe {
            width: 100%;
            height: 100%;
            border: none;
        }

        .right-side {
            flex: 2;
            justify-content: center;
            /* Decreased from 2 to 1 */
        }

        .bids-container {
            width: 100%;
        }

        .bid-item {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            transition: background-color 0.3s ease;
        }

        .bid-item:hover {
            background-color: #f9f9f9;
        }

        .bid-item:last-child {
            border-bottom: none;
        }

        .bid-amount {
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }

        .vehicle-name {
            font-size: 16px;
            color: #555;
        }

        .created-at {
            font-size: 14px;
            color: #999;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
    <header>
        <nav>
            <div class="logo">AuctionPlatform</div>
            <ul>
                <li><a href="http://localhost/Auction_System/user_profile.php#home">Home</a></li>
                <li><a href="user_profile_info.php">Profile</a></li>
                <li><a href="#">My bids</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    

    <div class="container">
        <div class="left-side">
            <iframe src="https://lottie.host/embed/7e25f46f-0172-460a-9adc-aa5476ca29cd/imkjX2wG1N.json"
                style="width: 100%; height: 100%; border: none;"></iframe>
        </div>
        <div class="right-side">
            <section class="bids-container">
                <h2>Your Bids</h2>
                <?php if (empty($bids)): ?>
                    <p>No bids found.</p>
                <?php else: ?>
                    <?php foreach ($bids as $bid): ?>
                        <div class="bid-item">
                            <div class="bid-amount">Bid Amount: $<?php echo number_format($bid['bid_amount'], 2); ?></div>
                            <div class="vehicle-name">Vehicle: <?php echo htmlspecialchars($bid['vehicle_name']); ?></div>
                            <div class="created-at">Placed on:
                                <?php echo date('F j, Y, g:i a', strtotime($bid['created_at'])); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </section>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 AuctionPlatform. All rights reserved.</p>
    </footer>
</body>

</html>