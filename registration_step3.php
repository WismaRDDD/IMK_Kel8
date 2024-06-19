<?php
session_start();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirm']) && isset($_POST['agree'])) {
    // Validate agreement to terms & conditions
    if (!isset($_POST['agree'])) {
        die("Please agree to the terms & conditions.");
    }

    // Insert data into users table after confirmation
    $username = $_SESSION['registration_data']['username'];
    $password = $_SESSION['registration_data']['password'];

    // Check if room_id, months, and total_price are set
    $room_id = isset($_SESSION['registration_data']['room_id']) ? $_SESSION['registration_data']['room_id'] : null;
    $months = isset($_SESSION['registration_data']['months']) ? $_SESSION['registration_data']['months'] : null;
    $total_price = isset($_SESSION['registration_data']['total_price']) ? $_SESSION['registration_data']['total_price'] : null;

    // Calculate end_date based on current date + months
    $end_date = date('Y-m-d', strtotime("+" . $months . " months"));

    // Database connection
    $conn = new mysqli('localhost', 'id22333213_kostgasrental', 'Vinturbodiesel1[', 'id22333213_kostgas');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Hash the password before storing it for security
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Insert user data into users table
    $stmt = $conn->prepare("INSERT INTO users (username, password, end_date, is_paid, is_approved, room_id, months, total_price, reservation_created_at) 
                            VALUES (?, ?, ?, 0, 0, ?, ?, ?, NOW())");
    $stmt->bind_param("sssiid", $username, $hashed_password, $end_date, $room_id, $months, $total_price);

    if ($stmt->execute()) {
        $user_id = $stmt->insert_id;

        // Clear session data after successful registration
        unset($_SESSION['registration_data']);
        session_destroy();

        // Close database connection
        $stmt->close();
        $conn->close();

        // JavaScript for popup message
        echo '<script>';
        echo 'alert("Registration successful. User ID: ' . $user_id . '");';
        echo 'window.location.href = "index.php";'; // Redirect to index.php after user closes the alert
        echo '</script>';
        exit;
    } else {
        if ($stmt->errno == 1062) {
            echo "Error: Username '$username' already exists.";
        } else {
            echo "Error: " . $stmt->error;
        }
    }

    $stmt->close();
    $conn->close();
}

// Handling form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirm']) && isset($_POST['agree'])) {
    // Example: send email or further process confirmation
    $to = 'admin@example.com';
    $subject = 'Payment Proof for Room ' . $room_id;
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
