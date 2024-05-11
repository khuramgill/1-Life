<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Need Fund</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <?php 
    $active = 'need_fund';
    include('head.php');
    ?>

    <div class="container" style="margin-top: 50px;">
        <div class="row">
            <div class="col-lg-6">
                <h1 class="mt-4 mb-3">Need Fund</h1>
                <form name="needfund" method="post">
                    <div class="form-group">
                        <label for="amount">Amount Needed<span style="color:red">*</span></label>
                        <select name="amount" class="form-control" required>
                            <option value="" selected disabled>Select</option>
                            <?php
                            include './admin/conn.php';
                            $sql = "SELECT * FROM donation_amount";
                            $result = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo '<option value="' . $row['Amount'] . '">' . $row['Amount'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <button type="submit" name="search" class="btn btn-primary">Search</button>
                </form>
            </div>
        </div>

        <?php
        if (isset($_POST['search'])) {
            include './conn.php';
            $required_amount = $_POST['amount']; // Corrected variable name
        
            // Get the money donors for the selected amount
            $sql = "SELECT CONCAT(firstName, ' ', lastName) AS fullName, gender, CNIC
                    FROM moneyDonor
                    JOIN contactinformation ON moneyDonor.user_Id = contactinformation.user_Id
                    WHERE amount = '{$required_amount}'";
        
            $result = mysqli_query($conn, $sql) or die("Query unsuccessful.");
            if (mysqli_num_rows($result) > 0) {
                echo "<div class='row'>";
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <div class="col-lg-4 col-sm-6 portfolio-item">
                        <div class="card mb-4">
                            <img class="card-img-top" src="images/blood_drop_logo.jpg" alt="Card image" style="width:100%; height:300px;">
                            <div class="card-body">
                                <h3 class="card-title"><?php echo isset($row['fullName']) ? $row['fullName'] : 'N/A'; ?></h3>
                                <p class="card-text">
                                    <b>Amount Range: </b><?php echo $required_amount; ?><br>
                                    <b>Mobile No.: </b><?php echo isset($row['phone']) ? $row['phone'] : 'N/A'; ?><br>
                                    <b>Gender: </b><?php echo isset($row['gender']) ? $row['gender'] : 'N/A'; ?><br>
                                    <b>CNIC: </b><?php echo isset($row['CNIC']) ? $row['CNIC'] : 'N/A'; ?><br>
                                    <b>Address: </b><?php echo isset($row['address']) ? $row['address'] : 'N/A'; ?><br>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php
                }
                echo "</div>"; // Close row div
            } else {
                echo '<div class="alert alert-danger">No Donor Found for the selected range of amount.</div>';
            }
        }
        ?>

    </div>

</body>

</html>
