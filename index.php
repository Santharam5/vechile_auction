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
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Auction System</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="js/scripts.js" defer></script>
    <script src="https://unpkg.com/scrollreveal"></script> <!-- Include ScrollReveal.js -->
</head>

<body>
    <header>
        <nav>
            <div class="logo">AuctionPlatform</div>
            <ul>
                <li><a href="#home" style="
                    display: inline-block;
                    padding: 10px 15px;
                    margin: 5px;
                    font-size: 16px;
                    color: white;
                    text-decoration: none;
                    transition: color 0.3s ease, transform 0.3s ease;
                " onmouseover="this.style.color='white'; this.style.transform='scale(1.05)';"
                        onmouseout="this.style.color='white'; this.style.transform='scale(1)';">Home</a></li>
                <li><a href="http://localhost/Auction_System/search.php?query=" style="
                    display: inline-block;
                    padding: 10px 15px;
                    margin: 5px;
                    font-size: 16px;
                    color: white;
                    text-decoration: none;
                    transition: color 0.3s ease, transform 0.3s ease;
                " onmouseover="this.style.color='white'; this.style.transform='scale(1.05)';"
                        onmouseout="this.style.color='white'; this.style.transform='scale(1)';">Auctions</a></li>
                <li><a href="#how-it-works" style="
                    display: inline-block;
                    padding: 10px 15px;
                    margin: 5px;
                    font-size: 16px;
                    color: white;
                    text-decoration: none;
                    transition: color 0.3s ease, transform 0.3s ease;
                " onmouseover="this.style.color='white'; this.style.transform='scale(1.05)';"
                        onmouseout="this.style.color='white'; this.style.transform='scale(1)';">How It Works</a></li>
                <li><a href="aboutus.php" style="
                    display: inline-block;
                    padding: 10px 15px;
                    margin: 5px;
                    font-size: 16px;
                    color: white;
                    text-decoration: none;
                    transition: color 0.3s ease, transform 0.3s ease;
                " onmouseover="this.style.color='white'; this.style.transform='scale(1.05)';"
                        onmouseout="this.style.color='white'; this.style.transform='scale(1)';">About</a></li>
                <li><a href="contactus.php" style="
                    display: inline-block;
                    padding: 10px 15px;
                    margin: 5px;
                    font-size: 16px;
                    color: white;
                    text-decoration: none;
                    transition: color 0.3s ease, transform 0.3s ease;
                " onmouseover="this.style.color='white'; this.style.transform='scale(1.05)';"
                        onmouseout="this.style.color='white'; this.style.transform='scale(1)';">Contact</a></li>
                <li>
                    <a href="login.php" style="
                        display: inline-block;
                        padding: 10px 20px;
                        margin: 10px;
                        font-size: 16px;
                        font-weight: bold;
                        color: white;
                        background-color: #007BFF;
                        border: none;
                        border-radius: 5px;
                        text-decoration: none;
                        transition: background-color 0.3s ease, transform 0.3s ease;
                    " onmouseover="this.style.backgroundColor='#0056b3'; this.style.transform='scale(1.05)';"
                        onmouseout="this.style.backgroundColor='#007BFF'; this.style.transform='scale(1)';">
                        Login/Register
                    </a></li>
                     <li>
                    <a href="http://localhost/Auction_System/admin/" style="
                        display: inline-block;
                        padding: 10px 20px;
                        margin: 10px;
                        font-size: 16px;
                        font-weight: bold;
                        color: white;
                        background-color:rgb(255, 0, 0);
                        border: none;
                        border-radius: 5px;
                        text-decoration: none;
                        transition: background-color 0.3s ease, transform 0.3s ease;
                    " onmouseover="this.style.backgroundColor='rgb(255, 0, 0)'; this.style.transform='scale(1.05)';"
                        onmouseout="this.style.backgroundColor='rgb(255, 0, 0)'; this.style.transform='scale(1)';">
                        AdminLogin
                    </a>
                </li>
                </li>
            </ul>
        </nav>
    </header>


    <section id="hero">
        <div class="hero-content">
            <h1>Find Your Dream Vehicle</h1>
            <p>Bid on the best vehicles from the comfort of your home</p>
            <form id="search-form" method="GET" action="search.php">
                <input type="text" name="query" placeholder="Search for vehicles...">
                <button type="submit">Search</button>
            </form>
        </div>
    </section>

    <!-- Post Auction Button -->
    <div class="post-auction-container">
        <a href="login.php" class="post-auction-btn">Post Auction</a>
    </div>

    <section id="featured-auctions">
        <h2>Featured Auctions</h2>
        <div class="carousel">
            <?php
            // Assuming a connection to the database is already established
            $query = "SELECT * FROM auctions WHERE featured = 1";
            $result = mysqli_query($conn, $query);
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='auction-item' data-title='" . $row['title'] . "'>";
                echo "<img src='" . $row['image_url'] . "' alt='Vehicle Image'>";
                echo "<h3>" . $row['title'] . "</h3>";
                echo "<p>Current Bid: $" . $row['current_bid'] . "</p>";
                echo "</div>";
            }
            ?>
        </div>
    </section>

    <section id="how-it-works">
        <h2>How It Works</h2>
        <div class="steps">
            <div class="step">
                <h3>Step 1</h3>
                <p>Register an account</p>
            </div>
            <div class="step">
                <h3>Step 2</h3>
                <p>Browse auctions</p>
            </div>
            <div class="step">
                <h3>Step 3</h3>
                <p>Place your bid</p>
            </div>
            <div class="step">
                <h3>Step 4</h3>
                <p>Win and collect your vehicle</p>
            </div>
        </div>
    </section>

    <section id="testimonials">
        <h2>Testimonials</h2>
        <div class="testimonials-container">
            <div class="testimonial">
                <p>"Great experience! I found my dream car at a great price."</p>
                <h4>- John Doe</h4>
            </div>
            <div class="testimonial">
                <p>"Easy to use and excellent customer service."</p>
                <h4>- Jane Smith</h4>
            </div>
        </div>
    </section>
    <script>
        // Initialize ScrollReveal
        ScrollReveal().reveal('.logo', { duration: 1000, origin: 'left', distance: '50px' });
        ScrollReveal().reveal('nav ul li', { duration: 1000, origin: 'bottom', distance: '50px', interval: 200 });
        ScrollReveal().reveal('.hero-content h1', { duration: 1000, origin: 'top', distance: '50px' });
        ScrollReveal().reveal('.hero-content p', { duration: 1000, origin: 'top', distance: '50px', delay: 200 });
        ScrollReveal().reveal('.search-form', { duration: 1000, origin: 'top', distance: '50px', delay: 400 });
        ScrollReveal().reveal('.post-auction-container', { duration: 1000, origin: 'bottom', distance: '50px' });
        ScrollReveal().reveal('.featured-auctions h2', { duration: 1000, origin: 'top', distance: '50px' });
        ScrollReveal().reveal('.carousel', { duration: 1000, origin: 'bottom', distance: '50px', delay: 200 });
        ScrollReveal().reveal('.hero', { duration: 1000, origin: 'top', distance: '50px' });
        ScrollReveal().reveal('.post-auction-container', { duration: 1000, origin: 'bottom', distance: '50px' });
        ScrollReveal().reveal('.featured-auctions', { duration: 1000, origin: 'top', distance: '50px' });
        ScrollReveal().reveal('#testimonials h2', { duration: 1000, origin: 'top', distance: '50px' });
        ScrollReveal().reveal('.testimonials-container .testimonial', { duration: 1000, origin: 'bottom', distance: '50px', interval: 200 });
        ScrollReveal().reveal('footer p', { duration: 1000, origin: 'bottom', distance: '50px' });
    </script>

    <footer>
        <p>&copy; 2025 AuctionPlatform. All rights reserved.</p>
    </footer>
</body>

</html>