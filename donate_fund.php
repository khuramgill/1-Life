<?php
session_start();
$active = 'fund_donor';
include('head.php');
// Include database connection
include 'conn.php';

// Function to sanitize form data
function sanitize($conn, $data) {
    return mysqli_real_escape_string($conn, $data);
}


// function insertMoneyDonor($conn, $firstName, $lastName, $phone, $address, $gender, $cnic, $amount, $user_id) {
//     // Insert data into contactinformation table
//     $sql1 = "INSERT INTO contactinformation (user_id, address, phone) VALUES ('$user_id', '$address', '$phone')";
//     $result1 = mysqli_query($conn, $sql1);

//     // Get the last inserted ID from contactinformation table
//     // $contact_info_id = mysqli_insert_id($conn);

//     // Insert data into moneydonor table
//     $sql2 = "INSERT INTO moneydonor (contact_info_id, firstName, lastName, gender, CNIC, amount, user_id) VALUES ('$contact_info_id', '$firstName', '$lastName', '$gender', '$cnic', '$amount', '$user_id')";
//     $result3 = mysqli_query($conn, $sql2);

//     // Get the last inserted ID from moneydonor table
//     $query = "SELECT moneydonor_id FROM moneydonor ORDER BY moneydonor_id DESC LIMIT 1";
//     $result = mysqli_query($conn, $query);
//     $row = mysqli_fetch_assoc($result);
//     $moneydonor_id = $row['moneydonor_id'];

//     // Close the query
//     mysqli_free_result($result);

//     include('./admin/conn.php');

//     // Prepare the SQL statement for moneydonor_details table
//     $sql2 = "INSERT INTO moneydonor_details (moneydonor_id, firstName, lastName, phone, address, gender, CNIC, amount) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
//     $stmt2 = mysqli_prepare($conn, $sql2);

//     // Bind parameters for moneydonor_details table
//     mysqli_stmt_bind_param($stmt2, 'issssssi', $moneydonor_id, $firstName, $lastName, $phone, $address, $gender, $cnic, $amount);

//     // Execute the SQL statement for moneydonor_details table
//     $result2 = mysqli_stmt_execute($stmt2);

//     // Close the statement for moneydonor_details table
//     mysqli_stmt_close($stmt2);

//     // Check if both operations were successful
//     if ($result1 && $result2 && $result3) {
//         return true; // Success
//     } else {
//         return false; // Failure
//     }
// }


// function insertMoneyDonor($conn, $firstName, $lastName, $phone, $address, $gender, $cnic, $amount, $user_id) {
//     $firstName = sanitize($conn, $firstName);
//     $lastName = sanitize($conn, $lastName);
//     $phone = sanitize($conn, $phone);
//     $address = sanitize($conn, $address);
//     $gender = sanitize($conn, $gender);
//     $cnic = sanitize($conn, $cnic);
//     $amount = sanitize($conn, $amount);
//     $user_id = sanitize($conn, $user_id);
    

//     // Construct the SQL INSERT queries
//     $sql1 = "INSERT INTO moneydonor (firstName, lastName, gender, CNIC, amount, user_id)
//            VALUES ('$firstName', '$lastName', '$gender', '$cnic', '$amount', $user_id)";

//     $sql2 = "INSERT INTO contactinformation (user_id, phone, address)
//            VALUES ('$user_id', '$phone', '$address')";

//     // Execute the INSERT queries
//     $result1 = mysqli_query($conn, $sql1);
//     $result2 = mysqli_query($conn, $sql2);

//     // Check if both INSERT queries were successful
//     if ($result1 && $result2) {
//         return true; // Success
//     } else {
//         return false; // Failure
//     }
// }

// // Check if the form has been submitted
// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     // Retrieve form data and sanitize
//     $firstName = $_POST["firstName"];
//     $lastName = $_POST["lastName"];
//     $phone = $_POST["phone"];
//     $address = $_POST["address"];
//     $gender = $_POST["gender"];
//     $cnic = $_POST["CNIC"];
//     $amount = $_POST["amount"];

//     // Retrieve user_id of the logged-in user
//     $user_id = $_SESSION['id'];

//     // Insert data into moneydonor table
//     if (insertMoneyDonor($conn, $firstName, $lastName, $phone, $address, $gender, $cnic, $amount, $user_id)) {
//         $message = "Record added successfully!";
//         // You can redirect the user to a success page or display a success message here
//     } else {
//         $error = "Error: Unable to add record.";
//     }
// }

mysqli_close($conn);
?>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>
    <?php
    $active = 'fund_donor';

    // Check if user is already a donor
    if (isset($_SESSION['is_donor']) && $_SESSION['is_donor']) {
        
        // User is a donor, include CRUD_moneyDonor.php
        include('CRUD_moneyDonor.php');
    } else {
    ?>
    <div id="page-container" style="margin-top:50px; position: relative;min-height: 84vh;">
        <div class="container">
            <div id="content-wrap" style="padding-bottom:50px;">
                <div class="row">
                    <div class="col-lg-6">
                        <h1 class="mt-4 mb-3">Donate Fund</h1>
                    </div>
                </div>
                
                <form id="donationForm" action="save_moneyDonor_data.php" method="post">
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
                                    <option value="Prefer Not to Say">Prefer Not to Say</option>
                                </select>
                            </div>
                        </div>
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
                    
                    <div class="row">
                        <div class="col-lg-4 mb-4">
                            <div><input type="submit" class="btn btn-primary" value="Submit"></div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- Popup Modal -->
            <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="loginModalLabel">Confirm Ation</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="loginForm">
                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input type="text" class="form-control" id="username" name="username"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control" id="password" name="password"
                                            required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">OK</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
    <?php include('footer.php') ?>
    <!-- jQuery and Bootstrap JS
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
    $(document).ready(function () {
        // Show the login modal when the donation form is submitted
        $('#donationForm').submit(function (event) {
            event.preventDefault(); // Prevent default form submission
            $('#loginModal').modal('show'); // Show the login modal
        });

        // Handle login form submission
        $('#loginForm').submit(function (event) {
            event.preventDefault(); // Prevent default form submission
            // Perform AJAX request to validate credentials
            $.ajax({
                url: 'validate_donor.php', // Your PHP script to validate credentials
                type: 'POST',
                data: $(this).serialize(),
                success: function (response) {
                    if (response === 'success') {
                        // If login is successful, submit the donation form
                        $('#donationForm').submit();
                    } else {
                        alert('Invalid username or password');
                    }
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                    alert('An error occurred while processing your request.');
                }
            });
        });
    });
    </script>

    <?php
    }
    ?> -->

    <!-- include('footer.php'); -->
</body>

</html>

