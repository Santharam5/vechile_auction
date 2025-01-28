<?php
session_start();

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



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM admin WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) == 1) {
        $_SESSION['email'] = $email;
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $error = "Incorrect username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
        }

        .bg-video {
          
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: 0;
        }

        .login-container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
            width: 300px;
            text-align: center;
        }

        .login-container input[type="email"],
        .login-container input[type="password"] {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
        }

        .login-container input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #4CAF50;
            color: white;
            font-size: 16px;
        }

        .error {
            color: red;
            position: absolute;
            top: 10px;
            right: 10px;
        }
        .glass-effect {
            width: 100%;
            padding: 15px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
            font-size: 16px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            transition: background 0.3s ease;
        }

        .glass-effect::placeholder {
            color: #ddd;
        }

        .glass-effect:focus {
            background: rgba(255, 255, 255, 0.3);
            outline: none;
        }

        .glass-effect[type="submit"] {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }

        .glass-effect[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <video autoplay muted loop class="bg-video">
        <source src="video.mp4" type="video/mp4">
    </video>

    <div class="login-container">
        <h2>Admin Login</h2>
        <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
        <form method="post" action="">
            <input type="email" name="email" placeholder="Email" required class="glass-effect">
            <input type="password" name="password" placeholder="Password" required class="glass-effect">
            <input type="submit" value="Login" class="glass-effect">
        </form>
    </div>
</body>
</html>