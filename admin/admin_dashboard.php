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

if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['new_admin'])) {
    $new_email = $_POST['new_email'];
    $new_password = $_POST['new_password'];

    $query = "INSERT INTO admin (email, password) VALUES ('$new_email', '$new_password')";
    mysqli_query($conn, $query);
    $message = "New admin added successfully.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    
    <script src="https://unpkg.com/scrollreveal"></script> <!-- Include ScrollReveal.js -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
            background-color: gray;


        }

        .container {
            z-index: 1;
            width: 80%;
            margin-top: 50px;
            margin-left: 200px;
            overflow: hidden;
        }

        h2 {
            color: #333;
            text-align: center;
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            box-shadow: 0 2px 3px rgba(0, 0, 0, 0.1);
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .add-admin-btn {
            display: block;
            width: 200px;
            margin: 20px auto;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .add-admin-btn:hover {
            background-color: #45a049;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.4);
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        input[type=email],
        input[type=password],
        input[type=submit] {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type=submit] {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }

        input[type=submit]:hover {
            background-color: #45a049;
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            display: none;
        }

        .nav-bar {
            background-color: black;
            overflow: hidden;
        }

        .nav-bar a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
        }

        .nav-bar a:hover {
            background-color: #45a049;
        }

        button {
            padding: 10px 20px;
            margin: 5px;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .edit-btn,
        .edit-auction-btn {
            background-color: #4CAF50;
            /* Green */
            color: white;
        }

        .edit-btn:hover,
        .edit-auction-btn:hover {
            background-color: #45a049;
            transform: scale(1.05);
        }

        .delete-btn,
        .delete-auction-btn {
            background-color: #f44336;
            /* Red */
            color: white;
        }

        .delete-btn:hover,
        .delete-auction-btn:hover {
            background-color: #e53935;
            transform: scale(1.05);
        }
    </style>
</head>

<body>

    <div class="nav-bar">
        <a href="#" onclick="showSection('users')">Users</a>
        <a href="#" onclick="showSection('bids')">Bids</a>
        <a href="#" onclick="showSection('auctions')">Auctions</a>
        <a href="#" onclick="showSection('settings')">Settings</a>
    </div>
    <div class="container">
        <div id="settings" class="section glass-effect">
            <h2>Settings</h2>
            <table>
                <tr>
                    <th>Email</th>
                    <th>Password</th>
                </tr>
                <?php
                $query = "SELECT * FROM admin";
                $result = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                            <td>{$row['email']}</td>
                            <td>{$row['password']}</td>
                          </tr>";
                }
                ?>
            </table>
            <button class="add-admin-btn" onclick="openModal()">Add Admin</button>
        </div>

        <div id="users" class="section glass-effect">
            <h2>Users</h2>
            <table>
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Mobile Number</th>
                    <th>Profile Picture</th>
                    <th>Actions</th>
                </tr>
                <?php
                $query = "SELECT * FROM users";
                $result = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_assoc($result)) {
                    // Construct the profile picture URL using the relative path from the database
                    $profile_pic_path = htmlspecialchars($row['profilepic']); // Use htmlspecialchars for security
                    $profile_pic_url = '../' . $profile_pic_path; // Prepend the base directory
                
                    // Check if the file exists before trying to display it
                    if (file_exists($profile_pic_url)) {
                        $img_tag = "<img src='{$profile_pic_url}' alt='Profile Picture' width='100' height='100' style='border-radius: 50%;'>";
                    } else {
                        $img_tag = "<img src='../uploads/placeholder.png' alt='No Image' width='50'>"; // Placeholder image
                    }

                    echo "<tr>
                    <td>{$row['username']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['mnumber']}</td>
                    <td>{$img_tag}</td>
                    <td>
                <button class='edit-btn' data-id='{$row['id']}'>Edit</button>
                <button class='delete-btn' data-id='{$row['id']}'>Delete</button>
            </td>
                  </tr>";
                }
                ?>
            </table>
        </div>

        <div id="bids" class="section glass-effect">
            <h2>Bids</h2>
            <table>
        <tr>
            <th>Email</th>
            <th>Bid Amount</th>
            <th>Created At</th>
            <th>Vehicle Name</th>
            <th>Actions</th>
        </tr>
        <?php
        $query = "SELECT * FROM bids";
        $result = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$row['email']}</td>
                    <td>{$row['bid_amount']}</td>
                    <td>{$row['created_at']}</td>
                    <td>{$row['vehicle_name']}</td>
                    <td>
                       <button onclick=\"editBid({$row['id']})\">Edit</button>
                        <button onclick=\"deleteBid({$row['id']})\">Delete</button>
                    </td>
                  </tr>";
        }
        ?>
    </table>
        </div>

        <div id="auctions" class="section glass-effect">
            <h2>Auctions</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Image</th>
                    <th>Current Bid</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>

                <?php
                $query = "SELECT * FROM auctions";
                $result = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_assoc($result)) {
                    // Construct the image URL using the relative path from the database
                    $image_path = htmlspecialchars($row['image_url']); // Use htmlspecialchars for security
                    $image_url = '../' . $image_path; // Prepend the base directory
                
                    // Check if the file exists before trying to display it
                    if (file_exists($image_url)) {
                        $img_tag = "<img src='{$image_url}' alt='Auction Image' width='80' style='border-radius: 10px;'>";
                    } else {
                        $img_tag = "<img src='../uploads/placeholder.png' alt='No Image' width='50'>"; // Placeholder image
                    }

                    echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['title']}</td>
                    <td>{$img_tag}</td>
                    <td>{$row['current_bid']}</td>
                    <td>{$row['created_at']}</td>
                    <td>
                        <button class='edit-auction-btn' data-id='{$row['id']}'>Edit</button>
                        <button class='delete-auction-btn' data-id='{$row['id']}'>Delete</button>
                    </td>
                  </tr>";
                }
                ?>

            </table>
        </div>
    </div>

    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Add New Admin</h2>
            <form method="post" action="">
                <input type="email" name="new_email" placeholder="Email" required class="glass-effect">
                <input type="password" name="new_password" placeholder="Password" required class="glass-effect">
                <input type="submit" name="new_admin" value="Add Admin" class="glass-effect">
            </form>
        </div>
    </div>
    <div id="edit-popup" class="modal"
        style="display:none; position: fixed; z-index: 1; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0, 0, 0, 0.4);">
        <div class="modal-content"
            style="background-color: #fefefe; margin: 15% auto; padding: 20px; border: 1px solid #888; width: 80%; max-width: 500px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3); animation: fadeIn 0.5s;">
            <span class="close" onclick="closeEditPopup()"
                style="color: #aaa; float: right; font-size: 28px; font-weight: bold; cursor: pointer;">&times;</span>
            <h2 style="margin-top: 0;">Edit User</h2>
            <form id="edit-form" style="display: flex; flex-direction: column;">
                <input type="hidden" id="edit-id" name="id">
                <label for="edit-username"
                    style="margin-top: 10px; margin-bottom: 5px; font-weight: bold;">Username:</label>
                <input type="text" id="edit-username" name="username"
                    style="padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 16px;">
                <label for="edit-email" style="margin-top: 10px; margin-bottom: 5px; font-weight: bold;">Email:</label>
                <input type="email" id="edit-email" name="email"
                    style="padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 16px;">
                <label for="edit-mnumber" style="margin-top: 10px; margin-bottom: 5px; font-weight: bold;">Mobile
                    Number:</label>
                <input type="text" id="edit-mnumber" name="mnumber"
                    style="padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 16px;">
                <button type="submit"
                    style="padding: 10px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; font-size: 16px; cursor: pointer; transition: background-color 0.3s ease, transform 0.3s ease;">Update</button>
            </form>
        </div>
    </div>

    <div id="edit-popupp" class="modal"
        style="display:none; position: fixed; z-index: 1; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0, 0, 0, 0.4);">
        <div class="modal-content"
            style="background-color: #fefefe; margin: 15% auto; padding: 20px; border: 1px solid #888; width: 80%; max-width: 500px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3); animation: fadeIn 0.5s;">
            <span class="close" onclick="closeEditPopup()"
                style="color: #aaa; float: right; font-size: 28px; font-weight: bold; cursor: pointer;">&times;</span>
            <h2 style="margin-top: 0;">Edit Auction</h2>
            <form id="edit-auction-form" style="display: flex; flex-direction: column;">
                <input type="hidden" id="edit-auction-id" name="id">
                <label for="edit-auction-title"
                    style="margin-top: 10px; margin-bottom: 5px; font-weight: bold;">Title:</label>
                <input type="text" id="edit-auction-title" name="title"
                    style="padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 16px;">

                <label for="edit-auction-current-bid"
                    style="margin-top: 10px; margin-bottom: 5px; font-weight: bold;">Current Bid:</label>
                <input type="text" id="edit-auction-current-bid" name="current_bid"
                    style="padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 16px;">
                <button type="submit"
                    style="padding: 10px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; font-size: 16px; cursor: pointer; transition: background-color 0.3s ease, transform 0.3s ease;">Update</button>
            </form>
        </div>
    </div>
    <div id="editPopupForm" style="display:none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: white; padding: 20px; border: 1px solid #ccc; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); z-index: 1000; border-radius: 8px;">
    <form id="editBidForm" style="display: flex; flex-direction: column; gap: 10px;">
        <input type="hidden" name="id" id="editId">
        <label>Email:</label>
        <input type="text" name="email" id="editEmail" style="padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
        <label>Bid Amount:</label>
        <input type="text" name="bid_amount" id="editBidAmount" style="padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
        <label>Created At:</label>
        <input type="text" name="created_at" id="editCreatedAt" style="padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
        <label>Vehicle Name:</label>
        <input type="text" name="vehicle_name" id="editVehicleName" style="padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
        <button type="button" onclick="saveBid()" style="padding: 10px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer;">Save</button>
    </form>
</div>



    <script>
        function openModal() {
            document.getElementById('myModal').style.display = "block";
        }

        function closeModal() {
            document.getElementById('myModal').style.display = "none";
        }

        function showSection(sectionId) {
            var sections = document.getElementsByClassName('section');
            for (var i = 0; i < sections.length; i++) {
                sections[i].style.display = 'none';
            }
            document.getElementById(sectionId).style.display = 'block';
        }

        // Show the first section by default
        showSection('users');
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Handle delete button click
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function () {
                    const id = this.getAttribute('data-id');
                    if (confirm('Are you sure you want to delete this record?')) {
                        window.location.href = `delete.php?id=${id}`;
                    }
                });
            });

            // Handle edit button click
            document.querySelectorAll('.edit-btn').forEach(button => {
                button.addEventListener('click', function () {
                    const id = this.getAttribute('data-id');
                    // Fetch the data and show in the popup
                    fetch(`get_user.php?id=${id}`)
                        .then(response => response.json())
                        .then(data => {
                            document.getElementById('edit-username').value = data.username;
                            document.getElementById('edit-email').value = data.email;
                            document.getElementById('edit-mnumber').value = data.mnumber;
                            document.getElementById('edit-id').value = data.id;
                            document.getElementById('edit-popup').style.display = 'block';
                        });
                });
            });

            // Handle form submission
            document.getElementById('edit-form').addEventListener('submit', function (event) {
                event.preventDefault();
                const formData = new FormData(this);
                fetch('update_user.php', {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.text())
                    .then(data => {
                        alert('Record updated successfully');
                        location.reload();
                    });
            });
        });
    </script>
    <script>
        function closeEditPopup() {
            document.getElementById('edit-popup').style.display = "none";
        }

        document.addEventListener('DOMContentLoaded', function () {
            // Handle edit button click
            document.querySelectorAll('.edit-btn').forEach(button => {
                button.addEventListener('click', function () {
                    const id = this.getAttribute('data-id');
                    // Fetch the data and show in the popup
                    fetch(`get_user.php?id=${id}`)
                        .then(response => response.json())
                        .then(data => {
                            document.getElementById('edit-username').value = data.username;
                            document.getElementById('edit-email').value = data.email;
                            document.getElementById('edit-mnumber').value = data.mnumber;
                            document.getElementById('edit-id').value = data.id;
                            document.getElementById('edit-popup').style.display = 'block';
                        });
                });
            });

            // Handle form submission
            document.getElementById('edit-form').addEventListener('submit', function (event) {
                event.preventDefault();
                const formData = new FormData(this);
                fetch('update_user.php', {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.text())
                    .then(data => {
                        alert('Record updated successfully');
                        location.reload();
                    });
            });
        });
    </script>
    <script>
        function closeEditPopup() {
            document.getElementById('edit-popupp').style.display = "none";
        }

        document.addEventListener('DOMContentLoaded', function () {
            // Handle delete auction button click
            document.querySelectorAll('.delete-auction-btn').forEach(button => {
                button.addEventListener('click', function () {
                    const id = this.getAttribute('data-id');
                    if (confirm('Are you sure you want to delete this auction?')) {
                        window.location.href = `delete_auction.php?id=${id}`;
                    }
                });
            });

            // Handle edit auction button click
            document.querySelectorAll('.edit-auction-btn').forEach(button => {
                button.addEventListener('click', function () {
                    const id = this.getAttribute('data-id');
                    console.log(`Edit button clicked for auction ID: ${id}`); // Debugging log
                    // Fetch the data and show in the popup
                    fetch(`get_auction.php?id=${id}`)
                        .then(response => response.json())
                        .then(data => {
                            console.log(data); // Debugging log
                            document.getElementById('edit-auction-title').value = data.title;
                            document.getElementById('edit-auction-current-bid').value = data.current_bid;
                            document.getElementById('edit-auction-id').value = data.id;
                            document.getElementById('edit-popupp').style.display = 'block';
                        })
                        .catch(error => console.error('Error fetching auction data:', error)); // Error handling
                });
            });

            // Handle form submission
            document.getElementById('edit-auction-form').addEventListener('submit', function (event) {
                event.preventDefault();
                const formData = new FormData(this);
                fetch('update_auction.php', {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.text())
                    .then(data => {
                        alert('Auction updated successfully');
                        location.reload();
                    })
                    .catch(error => console.error('Error updating auction:', error)); // Error handling
            });
        });
    </script>
    <script>
        // Initialize ScrollReveal
        ScrollReveal().reveal('header h1', { duration: 1000, origin: 'top', distance: '50px' });
        ScrollReveal().reveal('.admin-section h2', { duration: 1000, origin: 'left', distance: '50px' });
        ScrollReveal().reveal('.admin-section form', { duration: 1000, origin: 'right', distance: '50px' });
        ScrollReveal().reveal('.admin-section p', { duration: 1000, origin: 'bottom', distance: '50px' });
    </script>
    <script>
        function editBid(id) {
    // Fetch bid details and show in a popup for editing
    $.get('get_bid_details.php', {id: id}, function(data) {
        // Parse the JSON data
        var bid = JSON.parse(data);

        // Populate the form with data
        $('#editId').val(bid.id);
        $('#editEmail').val(bid.email);
        $('#editBidAmount').val(bid.bid_amount);
        $('#editCreatedAt').val(bid.created_at);
        $('#editVehicleName').val(bid.vehicle_name);

        // Show the edit form
        $('#editPopupForm').show();
    });
}

        function deleteBid(id) {
            if (confirm('Are you sure you want to delete this bid?')) {
                // Send request to delete the bid
                $.post('delete_bid.php', {id: id}, function(response) {
                    if (response.success) {
                        location.reload();
                    } else {
                        alert('Failed to delete bid');
                    }
                }, 'json');
            }
        }

        function saveBid() {
    var formData = $('#editBidForm').serialize();
    
    // Log the form data to the console for debugging
    console.log('Form Data:', formData);
    
    $.post('update_bid.php', formData, function(response) {
        // Log the response from the server for debugging
        console.log('Server Response:', response);
        
        if (response.success) {
            location.reload();
        } else {
            alert('Failed to update bid: ' + response.error);
        }
    }, 'json').fail(function(jqXHR, textStatus, errorThrown) {
        // Log any errors for debugging
        console.error('Error:', textStatus, errorThrown);
        alert('Failed to update bid due to an error: ' + textStatus + ' - ' + errorThrown);
    });
}
</script>
   
</body>
</html>
</script>
</body>

</html>