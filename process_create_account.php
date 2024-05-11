<?php
// Include the function.php file
include 'function.php';

// Establish database connection
$conn = connectDB();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input data
    $username = sanitizeInput($conn, $_POST["username"]);
    $password = sanitizeInput($conn, $_POST["password"]);
    $email = sanitizeInput($conn, $_POST["email"]);

    // Hash the password
    $hashed_password = hash('sha256', $password);

    // Prepare insert statement
    $stmt = $conn->prepare("INSERT INTO users (username, password, email, role) VALUES (?, ?, ?, 'user')");
    $stmt->bind_param("sss", $username, $hashed_password, $email);

    // Execute the statement
    if ($stmt->execute()) {
        header("Location: ./Login.php");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>
