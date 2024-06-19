<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Database connection
    $db_host = 'localhost'; // MySQL server hostname
    $db_user = 'id22333213_kostgasrental'; // MySQL username, replace with your actual username
    $db_pass = 'Vinturbodiesel1['; // MySQL password, replace with your actual password
    $db_name = 'id22333213_kostgas'; // Database name, replace with your actual database name

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the user's information
$user_id = $_SESSION['user_id'];
$sql = "SELECT username FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($username);
$stmt->fetch();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KOSTGAS - Tenant Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #F5F5F5; /* Light background color */
        }
        .header {
            text-align: center;
            padding: 50px;
            background-color: #EFEEE7;
        }
        .header h1 {
            font-size: 48px;
            color: #333;
        }
        .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 50px;
        }
        .welcome {
            font-size: 24px;
        }
        .welcome h2 {
            margin: 10px 0;
        }
        .menu {
            list-style-type: none;
            padding: 0;
        }
        .menu li {
            margin: 20px 0;
            display: flex;
            align-items: center;
            font-size: 18px;
        }
        .menu li a {
            text-decoration: none;
            color: inherit;
            display: flex;
            align-items: center;
        }
        .menu li img {
            width: 24px;
            height: 24px;
            margin-right: 10px;
        }
        .qr-section {
            text-align: center;
        }
        .qr-section img {
            width: 200px;
            height: 200px;
            margin-bottom: 20px;
        }
        .qr-section button {
            background: linear-gradient(to right, #825af4, #10B374);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>KOSTGAS</h1>
    </div>
    <div class="container">
        <div class="welcome">
            <h2>Hello, <?php echo htmlspecialchars($username); ?></h2>
            <ul class="menu">
                <li><a href="tenant_profile.php"><img src="profile_icon.png" alt="Profile Icon">Your user profile</a></li>
                <li><a href="login.php"><img src="logout.png" alt="Logout Icon">Log out</a></li>
            </ul>
        </div>
        <div class="qr-section">
            <button onclick="window.location.href='scan_qr.php'">QR TO GATE</button>
        </div>
    </div>
</body>
</html>
