<?php
session_start();

include 'conn.php'; // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $user_id = $_SESSION['id'];
    echo("User" . $user_id);

    // Get the recent deleted moneydonor_id
    $sql_recent = "SELECT MAX(moneydonor_id) AS recent_id FROM moneydonor WHERE user_id=$user_id";
    $result_recent = mysqli_query($conn, $sql_recent);
    $row_recent = mysqli_fetch_assoc($result_recent);
    $recent_id = $row_recent['recent_id'];

    // Delete data from moneydonor table
    $sql1 = "DELETE FROM moneydonor WHERE user_id=$user_id";

    // Delete data from contactinformation table
    $sql2 = "DELETE FROM contactinformation WHERE user_id=$user_id";

    // Execute the DELETE queries
    $result1 = mysqli_query($conn, $sql1);
    $result2 = mysqli_query($conn, $sql2);


    include './admin/conn.php'; 
    // Prepare the DELETE query for moneydonor_details
    $sql_delete_details = "DELETE FROM moneydonor_details WHERE moneydonor_id = ?";
    $stmt_delete_details = mysqli_prepare($conn, $sql_delete_details);

    // Bind the parameter
    mysqli_stmt_bind_param($stmt_delete_details, 'i', $recent_id);

    // Execute the statement
    $result_delete_details = mysqli_stmt_execute($stmt_delete_details);

    // Close the statement
    mysqli_stmt_close($stmt_delete_details);
    
    
    if ($result1 && $result2 && $result_delete_details) {
        unset($_SESSION['is_donor']);
        header("Location: donate_fund.php"); // Redirect to view page after successful delete
        exit();
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
}

mysqli_close($conn);

?>
