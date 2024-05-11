<?php
include 'conn.php'; // Include database connection
session_start();
$active = 'blood_donor';
$user_id = $_SESSION['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $fullname = mysqli_real_escape_string($conn, $_POST["fullname"]);
    $mobileno = mysqli_real_escape_string($conn, $_POST["mobileno"]);
    $address = mysqli_real_escape_string($conn, $_POST["address"]);
    $age = mysqli_real_escape_string($conn, $_POST["age"]);
    $gender = mysqli_real_escape_string($conn, $_POST["gender"]);
    $blood_type_id = mysqli_real_escape_string($conn, $_POST["blood"]); // Retrieve blood type ID
    $medical = mysqli_real_escape_string($conn, $_POST["medical"]);

    // Start a transaction
    mysqli_begin_transaction($conn);

    // Insert medical history into 'medicalhistory' table
    $insertContactInformation = "INSERT INTO contactinformation (phone, address, user_id) VALUES ('$mobileno', '$address', '$user_id') ";
    if (mysqli_query($conn, $insertContactInformation)) {
        // Retrieve the ID of the inserted contact information
        $contactInfoId = mysqli_insert_id($conn);
    } else {
        mysqli_rollback($conn); // Rollback the transaction
        echo "Error: " . $insertContactInformation . "<br>" . mysqli_error($conn);
    }
    $insertMedicalSql = "INSERT INTO medicalhistory (history_description ,user_id ) VALUES ('$medical' , '$user_id' ) ";
    if (mysqli_query($conn, $insertMedicalSql)) {
        // Retrieve the ID of the inserted medical history
        $medicalHistoryId = mysqli_insert_id($conn);

        // Construct the SQL INSERT query for 'blood_donors' table
        $sql = "INSERT INTO blood_donors (name, age, gender, blood_type_id, contact_info_id, medical_history_id , user_id)
                VALUES ('$fullname', '$age', '$gender', '$blood_type_id', $contactInfoId, '$medicalHistoryId' , '$user_id')";

        // Execute the INSERT query
        if (mysqli_query($conn, $sql)) {
            mysqli_commit($conn); // Commit the transaction
            $_SESSION['is_blood_donor'] = true;
            include('CRUD_bloodDonor.php');
            // You can redirect the user to a success page or display a success message here
        } else {
            mysqli_rollback($conn); // Rollback the transaction
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    } else {
        mysqli_rollback($conn); // Rollback the transaction
        echo "Error: " . $insertMedicalSql . "<br>" . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
