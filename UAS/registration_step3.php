<?php
session_start(); // Start the session to get user data

// Database configuration
$host = 'localhost'; // Replace with your host
$db = 'kostgas'; // Database name
$user = 'root'; // Replace with your database username
$pass = ''; // Replace with your database password

// Create a connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user details based on session or a unique identifier
$user_id = $_SESSION['user_id']; // Assuming user_id is stored in session
$sql = "
SELECT r.room_number, u.username
FROM reservations res
JOIN rooms r ON res.room_id = r.id
JOIN users u ON res.user_id = u.id
WHERE res.user_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($room_number, $username);
$stmt->fetch();
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirm']) && isset($_POST['agree'])) {
    $to = '2210511130@mahasiswa.upnvj.ac.id';
    $subject = 'PAYMENT PROOF ROOM ' . $room_number;
    $message = "
    Dear Admin,

    I hope this message finds you well. I am writing to provide the payment proof for my room rental. Attached to this email, you will find a scanned copy of the receipt as proof of payment.

    If there are any further steps I need to take or any additional information you require, please do not hesitate to contact me at this email address or by phone.

    Thank you for your attention to this matter.

    Sincerely,
    $username
    ";

    $headers = 'From: noreply@yourdomain.com' . "\r\n" .
                'Reply-To: noreply@yourdomain.com' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();

    if (mail($to, $subject, $message, $headers)) {
        echo '<p>Confirmation email has been sent.</p>';
    } else {
        echo '<p>There was an error sending the confirmation email.</p>';
    }
}

// Generate mailto link for contact person
$mailto_link = "https://mail.google.com/mail/?view=cm&fs=1&to=2210511130@mahasiswa.upnvj.ac.id&su=" . urlencode("PAYMENT PROOF ROOM $room_number") . "&body=" . urlencode("
Dear Admin,

I hope this message finds you well. I am writing to provide the payment proof for my room rental. Attached to this email, you will find a scanned copy of the receipt as proof of payment.

If there are any further steps I need to take or any additional information you require, please do not hesitate to contact me at this email address or by phone.

Thank you for your attention to this matter.

Sincerely,
$username
");

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KOSTGAS Registration Step 3</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            display: flex;
            justify-content: space-between;
            padding: 20px;
        }
        .terms, .payment {
            width: 45%;
        }
        .terms ul {
            list-style-type: none;
            padding: 0;
        }
        .terms ul li {
            margin: 5px 0;
        }
        .buttons {
            display: flex;
            justify-content: space-between;
        }
        .buttons button {
            padding: 10px 20px;
            border: none;
            background-color: #6A5ACD;
            color: white;
            cursor: pointer;
        }
        .buttons button:hover {
            background-color: #483D8B;
        }
        .buttons a {
            padding: 10px 20px;
            border: none;
            background-color: #6A5ACD;
            color: white;
            text-decoration: none;
            text-align: center;
            display: inline-block;
        }
        .buttons a:hover {
            background-color: #483D8B;
        }
    </style>
</head>
<body>
    <h1>KOSTGAS</h1>
    <form action="registration_step3.php" method="post">
        <div class="container">
            <div class="terms">
                <h2>Terms & Conditions</h2>
                <ul>
                    <li>Be mindful of fellow neighbour</li>
                    <li>No Sexual Activity</li>
                    <li>No Additional People</li>
                    <li>Not bringing any forbidden items by the law to the building</li>
                    <li>If your rent already expired you can't go in</li>
                </ul>
                <label>
                    <input type="checkbox" name="agree" required> Agree to Terms & Conditions
                </label>
            </div>
            <div class="payment">
                <h2>Payment</h2>
                <p>Via</p>
                <p>BNI Zulfikar 80823128</p>
                <p>BCA Zulfikar 9032345</p>
                <p>Send the payment proof to the email of the Contact Person</p>
                <p>You need to wait for it to be accepted</p>
            </div>
        </div>
        <div class="buttons">
            <button type="submit" name="confirm">CONFIRMATION</button>
            <a href="<?php echo $mailto_link; ?>" target="_blank">CONTACT PERSON</a>
        </div>
    </form>
</body>
</html>
