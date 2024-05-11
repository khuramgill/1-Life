<?php
session_start();
$active = 'donate';
include('head.php');
include('conn.php');

// Check if the user is a blood donor
if (isset($_SESSION['is_blood_donor']) && $_SESSION['is_blood_donor']) {
    // Include CRUD operations for blood donor
    include('CRUD_bloodDonor.php');
} else {
    // If the user is not a blood donor, display the update form
    if (isset($_GET['id'])) {
        // Get the donor ID from the URL
        $user_id = $_GET['id'];

        // Fetch the donor data from the database based on the ID
        $sql = "SELECT * FROM blood_donors WHERE user_id = $user_id";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
?>
        <div id="page-container" style="margin-top: 50px; position: relative; min-height: 84vh;">
            <div class="container">
                <div id="content-wrap" style="padding-bottom: 50px;">
                    <div class="row">
                        <div class="col-lg-6">
                            <h1 class="mt-4 mb-3">Update Blood Donor Data</h1>
                        </div>
                    </div>
                    <form name="update_donor" action="update_bloodDonor.php" method="post">
                        <input type="hidden" name="donor_id" value="<?php echo $donor_id; ?>">
                        <div class="row">
                            <div class="col-lg-4 mb-4">
                                <div class="font-italic">Full Name<span style="color:red">*</span></div>
                                <div><input type="text" name="fullname" class="form-control" value="<?php echo $row['name']; ?>" required></div>
                            </div>
                            <div class="col-lg-4 mb-4">
                                <div class="font-italic">Mobile Number<span style="color:red">*</span></div>
                                <div><input type="text" name="mobileno" class="form-control" value="<?php echo $row['phone']; ?>" required></div>
                            </div>
                            <div class="col-lg-4 mb-4">
                                <div class="font-italic">Address</div>
                                <div><textarea class="form-control" name="address"><?php echo $row['address']; ?></textarea></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 mb-4">
                                <div class="font-italic">Age<span style="color:red">*</span></div>
                                <div><input type="text" name="age" class="form-control" value="<?php echo $row['age']; ?>" required></div>
                            </div>
                            <div class="col-lg-4 mb-4">
                                <div class="font-italic">Gender<span style="color:red">*</span></div>
                                <div>
                                    <select name="gender" class="form-control" required>
                                        <option value="">Select</option>
                                        <option value="Male" <?php if ($row['gender'] == 'Male') echo 'selected'; ?>>Male</option>
                                        <option value="Female" <?php if ($row['gender'] == 'Female') echo 'selected'; ?>>Female</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-4">
                                <div class="font-italic">Blood Group<span style="color:red">*</span></div>
                                <div>
                                    <select name="blood" class="form-control" required>
                                        <option value="">Select Blood Type</option>
                                        <?php
                                        $sql_blood = "SELECT * FROM BloodTypes";
                                        $result_blood = mysqli_query($conn, $sql_blood);
                                        if (mysqli_num_rows($result_blood) > 0) {
                                            while ($blood_row = mysqli_fetch_assoc($result_blood)) {
                                                $selected = ($row['blood_type_id'] == $blood_row['blood_type_id']) ? 'selected' : '';
                                                echo '<option value="' . $blood_row['blood_type_id'] . '" ' . $selected . '>' . $blood_row['blood_group'] . $blood_row['rh_factor'] . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 mb-4">
                                <div class="font-italic">Medical History<span style="color:red">*</span></div>
                                <div><textarea class="form-control" name="medical" required><?php echo $row['history_description']; ?></textarea></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 mb-4">
                                <div><input type="submit" name="update" class="btn btn-primary" value="Update" style="cursor:pointer"></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
<?php
    }
}
?>
