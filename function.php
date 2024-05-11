<?php

// Function to establish a database connection
function connectDB() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "1life";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

// Function to prevent SQL injection
function sanitizeInput($conn, $data) {
    // Remove whitespace and escape special characters
    $data = trim($data);
    $data = mysqli_real_escape_string($conn, $data);
    return $data;
}

// Function to delete records from moneydonor and contactinformation tables based on user ID
function deleteMDRecords($conn, $user_id) {
    // Sanitize user ID
    $user_id = mysqli_real_escape_string($conn, $user_id);

    // Construct the SQL DELETE queries
    $sql1 = "DELETE FROM moneydonor WHERE user_id='$user_id'";
    $sql2 = "DELETE FROM contactinformation WHERE user_id='$user_id'";

    // Execute the DELETE queries
    $result1 = mysqli_query($conn, $sql1);
    $result2 = mysqli_query($conn, $sql2);

    // Check if both DELETE queries were successful
    if ($result1 && $result2) {
        return true; // Success
    } else {
        return false; // Failure
    }
}

?>
