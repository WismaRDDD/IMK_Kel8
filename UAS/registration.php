<!DOCTYPE html>
<html>
<head>
    <title>KOSTGAS - Registration</title>
    <style>
        * {
            font-family: Playfair Display, serif;
        }

        body {
            font-family: Arial, sans-serif;
            padding: 250px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
            overflow: hidden;
            background: linear-gradient(to right, #A6A6A6, #EFEEE7);
        }

        .container {
            display: flex;
            background: #ffffff;
            border-radius: 100px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            opacity: 0.8;
        }

        .container .form-box {
            padding: 20px;
            background-color: #EFEEE7;
        }

        .container .form-box input[type="text"], .container .form-box input[type="password"] {
            width: 75%;
            padding: 10px;
            margin: 10px 0;
            border: 2px solid #000000;
            border-radius: 1px;
        }

        .container .form-box input[type="text"]::placeholder,
        .container .form-box input[type="password"]::placeholder {
            color: #000000;
            font-weight: bold;
        }

        .container .form-box .button {
            display: block;
            width: 30%;
            padding: 10px;
            border: none;
            border-radius: 25px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            background: linear-gradient(to right, #825af4, #10B374);
            margin-top: 20px;
            font-weight: bold;
        }

        .container .info-box hr {
            margin-right: 10px;
            height: 150px;
            border: 2px solid #EFEEE7;
            border-radius: 15px;
        }

        .container .info-box {
            background-color: #A6A6A6;
            padding: 40px;
            border-radius: 0 10px 10px 0;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #EFEEE7;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-box">
            <h2>Registration</h2>
            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $username = $_POST['username'];
                $password = $_POST['password'];

                // Database connection
                $conn = new mysqli('localhost', 'root', '', 'kostgas');

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Check if username already exists
                $stmt_check = $conn->prepare("SELECT id FROM users WHERE username = ?");
                $stmt_check->bind_param("s", $username);
                $stmt_check->execute();
                $stmt_check->store_result();

                if ($stmt_check->num_rows > 0) {
                    echo "Username already exists. Please choose a different username.";
                    $stmt_check->close();
                } else {
                    $stmt_check->close();

                    // Hash the password before storing it for security
                    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

                    // Insert user data into users table
                    $stmt = $conn->prepare("INSERT INTO users (username, password, user_type) VALUES (?, ?, 'tenant')");
                    $stmt->bind_param("ss", $username, $hashed_password);

                    if ($stmt->execute()) {
                        $user_id = $stmt->insert_id;

                        // Insert initial reservation data with the new user_id
                        $stmt_res = $conn->prepare("INSERT INTO reservations (user_id) VALUES (?)");
                        $stmt_res->bind_param("i", $user_id);

                        if ($stmt_res->execute()) {
                            // Redirect to registration_step2.php after successful registration
                            header("Location: registration_step2.php");
                            exit();
                        } else {
                            echo "Error: " . $stmt_res->error;
                        }

                        $stmt_res->close();
                    } else {
                        echo "Error: " . $stmt->error;
                    }

                    $stmt->close();
                }

                $conn->close();
            }
            ?>
            <form method="post" action="">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button class="button" type="submit">N E X T</button>
            </form>
        </div>
        <div class="info-box">
            <hr>
            <h1>KOSTGAS</h1>
        </div>
    </div>
</body>
</html>