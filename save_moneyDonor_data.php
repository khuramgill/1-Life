<?php
include 'conn.php'; // Include database connection
session_start();
$active = 'fund_donor';
$user_id = $_SESSION['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $firstName = mysqli_real_escape_string($conn, $_POST["firstName"]);
    $lastName = mysqli_real_escape_string($conn, $_POST["lastName"]);
    $phone = mysqli_real_escape_string($conn, $_POST["phone"]);
    $address = mysqli_real_escape_string($conn, $_POST["address"]);
    $gender = mysqli_real_escape_string($conn, $_POST["gender"]);
    $cnic = mysqli_real_escape_string($conn, $_POST["CNIC"]);
    $amount = mysqli_real_escape_string($conn, $_POST["amount"]);

    // Start a transaction
    mysqli_begin_transaction($conn);

    // Insert medical history into 'medicalhistory' table
    $insertContactInformation = "INSERT INTO contactinformation (phone, address, user_id) VALUES ('$phone', '$address', '$user_id') ";
    if (mysqli_query($conn, $insertContactInformation)) {
        // Retrieve the ID of the inserted contact information
        $contactInfoId = mysqli_insert_id($conn);
    } else {
        mysqli_rollback($conn); // Rollback the transaction
        echo "Error: " . $insertContactInformation . "<br>" . mysqli_error($conn);
    }
    // Construct the SQL INSERT query for 'moneydonor' table
    $sql = "INSERT INTO moneydonor (firstName, lastName, gender, CNIC, amount, user_id, contact_info_id)
    VALUES ('$firstName', '$lastName', '$gender', '$cnic', '$amount', '$user_id', $contactInfoId)";


    // Execute the INSERT query
    if (mysqli_query($conn, $sql)) {
        mysqli_commit($conn); // Commit the transaction
        $_SESSION['is_donor'] = true;
        header("Location: donate_fund.php"); 
    } else {
        mysqli_rollback($conn); // Rollback the transaction
        echo "Error inserting Money Donor data: " . mysqli_error($conn);
    }
    } else {
    mysqli_rollback($conn); // Rollback the transaction
    echo "Error inserting Contact Information: " . mysqli_error($conn);
    }


mysqli_close($conn);
?>



