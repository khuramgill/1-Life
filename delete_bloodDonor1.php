<?php
session_start();
// $conn=mysqli_connect("localhost","root","","1life") or die("Connection error");
include 'conn.php'; // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $user_id = $_SESSION['id'];    
    // Start a transaction
    mysqli_begin_transaction($conn);
    // Delete data from blood_donors table
    $sql1 = "DELETE FROM blood_donors WHERE user_id=$user_id";
    // Delete data from contactinformation table
    $sql2 = "DELETE FROM contactinformation WHERE user_id=$user_id";
    // Execute the DELETE queries
    $result1 = mysqli_query($conn, $sql1);
    $result2 = mysqli_query($conn, $sql2);
    // Prepare the DELETE query for medicalhistory
    $sql_delete_medical = "DELETE FROM medicalhistory WHERE user_id = $user_id";
    $result3 = mysqli_query($conn, $sql_delete_medical); // Added a semicolon here
    // Check if all delete operations were successful
    if ($result1 && $result2 && $result3) {
        // Commit the transaction
        mysqli_commit($conn);        
        unset($_SESSION['is_blood_donor']);
        header("Location: donate_blood.php"); // Redirect to donate_blood page after successful delete
        exit();
    } else {
        // Rollback the transaction if any delete operation fails
        mysqli_rollback($conn);
        echo "Error deleting record: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
