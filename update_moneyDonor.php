<?php
session_start();

include 'conn.php'; // Include database connection

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    // Retrieve form data
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];
    $gender = $_POST["gender"];
    $cnic = $_POST["CNIC"];
    $amount = $_POST["amount"];
    $user_id = $_SESSION['id'];

    // Update data in moneydonor table
    $sql1 = "UPDATE moneydonor SET firstName='$firstName', lastName='$lastName', gender='$gender', CNIC='$cnic', amount='$amount' WHERE user_id=$user_id";

    // Update data in contactinformation table
    $sql2 = "UPDATE contactinformation SET phone='$phone', address='$address' WHERE user_id=$user_id";

    // Execute the UPDATE queries
    $result1 = mysqli_query($conn, $sql1);
    $result2 = mysqli_query($conn, $sql2);

    // Check if updates were successful
    if ($result1 && $result2) {
        header("Location: view_moneyDonor.php"); // Redirect to view page after successful update
        exit();
    } else {
        // Display error message if updates failed
        echo "Error updating record: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Money Donor</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2 class="mt-4 mb-4">Update Money Donor Information</h2>
        <form action="update_moneyDonor.php" method="post">
        <div class="row">
                        <div class="col-lg-4 mb-4">
                            <div class="font-italic">First Name<span style="color:red">*</span></div>
                            <div><input type="text" class="form-control" name="firstName" required></div>
                        </div>
                        <div class="col-lg-4 mb-4">
                            <div class="font-italic">Last Name<span style="color:red">*</span></div>
                            <div><input type="text" class="form-control" name="lastName" required></div>
                        </div>
                        <div class="col-lg-4 mb-4">
                            <div class="font-italic">Phone #<span style="color:red">*</span></div>
                            <div><input type="text" class="form-control" name="phone" required></div>
                        </div>
                        <div class="col-lg-4 mb-4">
                            <div class="font-italic">Address<span style="color:red">*</span></div>
                            <div><input type="text" class="form-control" name="address" required></div>
                        </div>
                        <div class="col-lg-4 mb-4">
                            <div class="font-italic">Gender<span style="color:red">*</span></div>
                            <div>
                                <select class="form-control" name="gender" required>
                                    <option value="">Select</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 mb-4">
                            <div class="font-italic">CNIC<span style="color:red">*</span></div>
                            <div><input type="text" class="form-control" name="CNIC" required></div>
                        </div>
                        <div class="col-lg-4 mb-4">
                            <div class="font-italic">Amount<span style="color:red">*</span></div>
                            <div>
                                <select class="form-control" name="amount" required>
                                    <option value="" selected disabled>Select</option>
                                    <?php
                                    include './admin/conn.php';
                                    $sql = "SELECT * FROM donation_amount";
                                    $result = mysqli_query($conn, $sql) or die("Query unsuccessful.");
                                    while($row = mysqli_fetch_assoc($result)) {
                                        echo "<option value='".$row['Amount']."'>".$row['Amount']."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
            <div class="col-lg-4 mb-4">
                            <div class="font-italic">Amount<span style="color:red">*</span></div>
                            <div>
                                <select class="form-control" name="amount" required>
                                    <option value="" selected disabled>Select</option>
                                    <?php
                                    include './admin/conn.php';
                                    $sql = "SELECT * FROM donation_amount";
                                    $result = mysqli_query($conn, $sql) or die("Query unsuccessful.");
                                    while($row = mysqli_fetch_assoc($result)) {
                                        echo "<option value='".$row['Amount']."'>".$row['Amount']."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
            <button type="submit" class="btn btn-primary" name="update">Update</button>
        </form>
    </div>
</body>
</html>
