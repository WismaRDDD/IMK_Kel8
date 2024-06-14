<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "kostgas";
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the user's information from the users table
$user_id = $_SESSION['user_id'];
$sql_user = "SELECT username FROM users WHERE id = ?";
$stmt_user = $conn->prepare($sql_user);
$stmt_user->bind_param("i", $user_id);
$stmt_user->execute();
$stmt_user->bind_result($username);
$stmt_user->fetch();
$stmt_user->close();

// Get the reservation information from the reservations table
$sql_reservation = "SELECT room_id, months, created_at FROM reservations WHERE id = ?";
$stmt_reservation = $conn->prepare($sql_reservation);
$stmt_reservation->bind_param("i", $user_id);
$stmt_reservation->execute();
$stmt_reservation->bind_result($room_id, $months, $created_at);
$stmt_reservation->fetch();
$stmt_reservation->close();

// Calculate the rent status (end date)
$rent_end_date = date('Y-m-d', strtotime($created_at. ' + ' . $months . ' months'));

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KOSTGAS - Tenant Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #F5F5F5; /* Light background color */
        }
        .container {
            display: flex;
            height: 100vh;
        }
        .profile-section {
            flex: 1;
            background-color: #EFEEE7;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .profile-section h1 {
            font-size: 36px;
            margin-bottom: 40px;
        }
        .profile-section .info {
            width: 300px;
        }
        .profile-section .info div {
            margin-bottom: 20px;
        }
        .profile-section .info div input {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #333;
            border-radius: 5px;
            box-sizing: border-box;
        }
        .profile-section .info button {
            background: linear-gradient(to right, #825af4, #10B374);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
        }
        .brand-section {
            flex: 1;
            background-color: #A9A9A9;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .brand-section h1 {
            font-size: 48px;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="profile-section">
            <h1>Profil User</h1>
            <div class="info">
                <div>
                    <input type="text" value="<?php echo htmlspecialchars($username); ?>" readonly>
                </div>
                <div>
                    <input type="text" value="<?php echo htmlspecialchars($room_id); ?>" readonly>
                </div>
                <div>
                    <input type="text" value="<?php echo htmlspecialchars($rent_end_date); ?>" readonly>
                </div>
                <div>
                    <button onclick="window.location.href='tenant_dashboard.php'">BACK TO HOMEPAGE</button>
                </div>
            </div>
        </div>
        <div class="brand-section">
            <h1>KOSTGAS</h1>
        </div>
    </div>
</body>
</html>