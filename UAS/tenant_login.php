<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "kostgas";
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];
$sql_user = "SELECT username FROM users WHERE id = ?";
$stmt_user = $conn->prepare($sql_user);
$stmt_user->bind_param("i", $user_id);
$stmt_user->execute();
$stmt_user->bind_result($username);
$stmt_user->fetch();
$stmt_user->close();

$conn->close();

// Encryption settings
$key = 'your-secret-key'; // Change this to your secret key
$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
$encrypted_username = openssl_encrypt($username, 'aes-256-cbc', $key, 0, $iv);
$encrypted_username = base64_encode($encrypted_username . '::' . $iv);

// Generate the URL with the encrypted data
$qr_data = 'http://localhost/your_project/decrypt_qr.php?data=' . urlencode($encrypted_username);

// Google Chart API for generating QR code
$google_chart_api = 'https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=' . urlencode($qr_data);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KOSTGAS - Tenant QR Code</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #F5F5F5;
        }
        .container {
            text-align: center;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .container img {
            margin-bottom: 20px;
        }
        .container button {
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
    <div class="container">
        <h1>Your Room QR Code</h1>
        <img src="<?php echo $google_chart_api; ?>" alt="Tenant QR Code">
        <br>
        <button onclick="window.location.href='tenant_dashboard.php'">BACK TO HOMEPAGE</button>
    </div>
</body>
</html>
