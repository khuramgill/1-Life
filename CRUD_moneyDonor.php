
<?php
// session_start();

include 'conn.php'; // Include database connection

// Check if the user has any records in the moneydonor table
$user_id = $_SESSION['id'];
$sql_check_record = "SELECT COUNT(*) AS record_count FROM moneydonor WHERE user_id = $user_id";
$result_check_record = mysqli_query($conn, $sql_check_record);
$row_check_record = mysqli_fetch_assoc($result_check_record);
$record_count = $row_check_record['record_count'];

if ($record_count > 0) {
    $_SESSION['is_donor'] = true;
} else {
    unset($_SESSION['is_donor']);
    header('Location: ./donate_fund.php');
}


$active = 'fund_donor';
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Congratulations!</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .center-div {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="center-div">
            <img src="./image/Congrats.gif" alt="Congratulations!" width="300">
            <br><br>
            <a href="view_moneyDonor.php?user_id=<?php echo $_SESSION['id']; ?>" class="btn btn-primary">View</a>
            <button type="button" class="btn btn-success" onclick="window.location.href='update_moneyDonor.php'">Update</button>
            
            <br><br>
            <a href="Certificate Generator/index.php" class="btn btn-primary">Generate Certificate</a>
            <form action="delete_moneyDonor.php" method="post">
            <button type="submit" class="btn btn-danger" name="delete">Delete</button>
            </form>
            

        </div>
    </div>
    <script>
        // Disable back button functionality
        window.history.pushState(null, "", window.location.href);
        window.onpopstate = function () {
        window.history.pushState(null, "", window.location.href);
        };
    </script>
</body>

</html>
