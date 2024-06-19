<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Database credentials
    $db_host = 'localhost'; // MySQL server hostname
    $db_username = 'id22333213_kostgasrental'; // MySQL username, replace with your actual username
    $db_password = 'Vinturbodiesel1['; // MySQL password, replace with your actual password
    $db_name = 'id22333213_kostgas'; // Database name, replace with your actual database name

    // Create a new connection
    $conn = new mysqli($db_host, $db_username, $db_password, $db_name);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute the query
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashed_password);
        $stmt->fetch();

        // Verify if hashed password matches the one entered
        if ($password == $hashed_password) {
            $_SESSION['user_id'] = $id;
            header('Location: tenant_dashboard.php');
            exit();
        } else {
            echo "<script>
                alert('Invalid password.');
                window.location.href = 'login.php';
                </script>";
        }
    } else {
        echo "<script>
            alert('No user found with the given username.');
            window.location.href = 'login.php';
            </script>";
    }

    $stmt->close();
    $conn->close();
}
?>

