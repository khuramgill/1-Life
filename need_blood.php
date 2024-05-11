<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Need Blood</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <?php 
    $active = 'need';
    include('head.php');
    ?>

    <div class="container" style="margin-top: 50px;">
        <div class="row">
            <div class="col-lg-6">
                <h1 class="mt-4 mb-3">Need Blood</h1>
                <form name="needblood" method="post">
                    <div class="form-group">
                        <label for="blood">Blood Group<span style="color:red">*</span></label>
                        <select name="blood" class="form-control" required>
                            <option value="" selected disabled>Select</option>
                            <?php
                            include 'conn.php';
                            $sql = "SELECT * FROM bloodtypes";
                            $result = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo '<option value="' . $row['blood_type_id'] . '">' . $row['blood_group'] . $row['rh_factor'] . '</option>';
                                }
                            }
                            $type = $_POST['blood'];
                            
                            ?>
                        </select>
                    </div>
                    <div class="form-group">

                        <label for="reason">Reason, why do you need blood?<span style="color:red">*</span></label>
                        <!-- <label for="reason">Reason, why do you need blood?<span style="color:red">*</span></label> -->
                        <textarea class="form-control" name="reason" required></textarea>
                    </div>
                    <button type="submit" name="search" class="btn btn-primary">Search</button>
                </form>
            </div>
        </div>

        <?php
        if (isset($_POST['search'])) {
            $bg = $_POST['blood'];
        
            // Get the blood group and RH factor for the selected blood type
            $sql_blood_group = "SELECT blood_group, rh_factor FROM bloodtypes WHERE blood_type_id = '{$bg}'";
            $result_blood_group = mysqli_query($conn, $sql_blood_group);
            if (!$result_blood_group) {
                die("Error fetching blood group: " . mysqli_error($conn));
            }
            $row_blood_group = mysqli_fetch_assoc($result_blood_group);
            if (!$row_blood_group) {
                die("Blood group not found");
            }
            $selected_blood_group = $row_blood_group['blood_group'];
            $selected_rh_factor = $row_blood_group['rh_factor'];
        
            // Construct the blood type string for comparison
            $selected_blood_type = $selected_blood_group . $selected_rh_factor;
        
            $sql = "SELECT bd.*, bt.blood_group
                    FROM blood_donors bd
                    JOIN bloodtypes bt ON bd.blood_type_id = bt.blood_type_id
                    WHERE CONCAT(bt.blood_group, bt.rh_factor) = '{$selected_blood_type}'
                    ORDER BY RAND()
                    LIMIT 5";
        
            $result = mysqli_query($conn, $sql) or die("Query unsuccessful.");
            if (mysqli_num_rows($result) > 0) {
                echo "<div class='row'>";
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <div class="col-lg-4 col-sm-6 portfolio-item">
                        <div class="card mb-4">
                            <img class="card-img-top" src="images/blood_drop_logo.jpg" alt="Card image" style="width:100%; height:300px;">
                            <div class="card-body">
                                <h3 class="card-title"><?php echo isset($row['name']) ? $row['name'] : 'N/A'; ?></h3>
                                <p class="card-text">
                                    <b>Blood Group: </b><?php echo $selected_blood_type; ?><br>
                                    <b>Mobile No.: </b><?php echo isset($row['number']) ? $row['number'] : 'N/A'; ?><br>
                                    <b>Gender: </b><?php echo isset($row['gender']) ? $row['gender'] : 'N/A'; ?><br>
                                    <b>Age: </b><?php echo isset($row['age']) ? $row['age'] : 'N/A'; ?><br>
                                    <b>Address: </b><?php echo isset($row['address']) ? $row['address'] : 'N/A'; ?><br>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php
                }
                echo "</div>"; // Close row div
            } else {
                echo '<div class="alert alert-danger">No Donor Found for the selected Blood Group.</div>';
            }
        }
        ?>

    </div>

</body>

</html>
