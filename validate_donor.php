<?php
session_start();

// Include the database connection
include 'conn.php';

// Function to sanitize input data
function sanitize($conn, $data) {
    return mysqli_real_escape_string($conn, $data);
}

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $username = sanitize($conn, $_POST["username"]);
    $password = sanitize($conn, $_POST["password"]);

    // Query to retrieve user from database
    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Verify password
        $hashedPassword = hash('sha256', $password);
        $hashedPasswordLimited = substr($hashedPassword, 0, 50);
        if($hashedPasswordLimited === $row['password']) {
            

            // Proceed with the rest of the script
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];
            $_SESSION['id'] = $row['id'];
            // print_r($_SESSION);
            echo 'success';
        } else {
            // Password is incorrect
            echo 'error';
        }
    } else {
        // Username not found
        echo 'error';
    }
}

// Close the database connection
mysqli_close($conn);
?>
