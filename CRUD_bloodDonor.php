
<!-- <?php 
include('head.php');
?> -->

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
            <a href="view_bloodDonor.php?user_id=<?php echo $_SESSION['id']; ?>" class="btn btn-primary">View</a>
            <button type="button" class="btn btn-success" onclick="window.location.href='update_bloodDonor.php'">Update</button>
            <form action="delete_bloodDonor1.php?user_id=<?php echo $_SESSION['id'];?>" method="post">
            <button type="submit" class="btn btn-danger" name="delete">Delete</button>
            </form>
            
            
            <a href="Certificate Generator/crt_bloodDonor.php" class="btn btn-primary">Generate Certificate</a>

        </div>
    </div>
</body>

</html>
