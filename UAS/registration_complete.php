<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Define required fields
    $required_fields = ['username', 'password', 'selected_room', 'months', 'total', 'payment_method', 'terms_agreed'];
    
    // Check for required fields
    foreach ($required_fields as $field) {
        if (!isset($_POST[$field])) {
            die("Missing required field: $field");
        }
    }

    // Retrieve form data
    $username = $_POST['username'];
    $password = $_POST['password'];
    $selected_room = $_POST['selected_room'];
    $months = $_POST['months'];
    $total = $_POST['total'];
    $payment_method = $_POST['payment_method'];
    $terms_agreed = $_POST['terms_agreed'];

    // Check terms agreement
    if ($terms_agreed != 1) {
        die("You must agree to the terms and conditions.");
    }

    // File upload validation
    if (!isset($_FILES['payment_proof'])) {
        die("File upload error: No file uploaded.");
    }

    if ($_FILES['payment_proof']['error'] != UPLOAD_ERR_OK) {
        die("File upload error: " . $_FILES['payment_proof']['error']);
    }

    // Process file upload
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["payment_proof"]["name"]);
    $upload_ok = 1;
    $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if file is an actual image
    $check = getimagesize($_FILES["payment_proof"]["tmp_name"]);
    if ($check === false) {
        die("File is not an image.");
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        die("Sorry, file already exists.");
    }

    // Check file size
    if ($_FILES["payment_proof"]["size"] > 5000000) { // 5MB
        die("Sorry, your file is too large.");
    }

    // Allow certain file formats
    if (!in_array($image_file_type, ["jpg", "jpeg", "png"])) {
        die("Sorry, only JPG, JPEG, and PNG files are allowed.");
    }

    // Move uploaded file to destination directory
    if (!move_uploaded_file($_FILES["payment_proof"]["tmp_name"], $target_file)) {
        die("Sorry, there was an error uploading your file.");
    }

    // Database operations
    $conn = new mysqli('localhost', 'root', '', 'kostgas');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert reservation data
    $stmt = $conn->prepare("INSERT INTO reservations (user_id, room_id, months, total_price, payment_proof, payment_method) VALUES ((SELECT id FROM users WHERE username = ?), (SELECT id FROM rooms WHERE room_number = ?), ?, ?, ?, ?)");

    if (!$stmt) {
        die("Prepare statement failed: " . $conn->error);
    }

    // Bind parameters
    $stmt->bind_param("ssids", $username, $selected_room, $months, $total, $target_file, $payment_method);

    // Execute the statement
    if ($stmt->execute()) {
        // Update room status
        $update_stmt = $conn->prepare("UPDATE rooms SET is_reserved = TRUE WHERE room_number = ?");
        
        if (!$update_stmt) {
            die("Prepare statement failed: " . $conn->error);
        }
        
        $update_stmt->bind_param("s", $selected_room);
        if (!$update_stmt->execute()) {
            die("Update room status failed: " . $update_stmt->error);
        }

        echo "Registration successful! Please wait for payment confirmation.";
    } else {
        die("Error executing statement: " . $stmt->error);
    }

    // Close statements and connection
    $stmt->close();
    $update_stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
