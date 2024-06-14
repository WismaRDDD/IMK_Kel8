<?php
if (!isset($_GET['data'])) {
    die("No data provided.");
}

$encrypted_data = $_GET['data'];
$key = 'your-secret-key'; // Same key used for encryption

list($encrypted_username, $iv) = explode('::', base64_decode($encrypted_data), 2);
$decrypted_username = openssl_decrypt($encrypted_username, 'aes-256-cbc', $key, 0, $iv);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Decrypted QR Code</title>
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
    </style>
</head>
<body>
    <div class="container">
        <h1>Decrypted Username</h1>
        <p><?php echo htmlspecialchars($decrypted_username); ?></p>
    </div>
</body>
</html>
