<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Information</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <style>
        body {
            padding: 20px;
        }

        .info-card {
            max-width: 500px;
            margin: 0 auto;
        }

        .back-btn {
            position: absolute;
            top: 20px;
            left: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <a class="btn btn-secondary back-btn" href="./donate_blood.php">&laquo; Back</a>
        <div class="info-card">
            <?php
            // Start the session
            session_start();

            // Include database connection
            include 'conn.php';

            // Check if donor ID is provided in the URL
            if (isset($_SESSION['id'])) {
                $user_id = $_SESSION['id'];

                // Fetch donor information from moneydonor and contactinformation tables
                $sql = "SELECT distinct
                bd.name AS Name,
                bd.age AS Age,
                bd.gender AS gender,
                ci.address AS address,
                ci.phone AS phone,
                CONCAT(bt.blood_group, bt.rh_factor) AS blood
            FROM 
                blood_donors bd
            LEFT JOIN 
                contactinformation ci ON bd.user_id = ci.user_id
            LEFT JOIN 
                bloodtypes bt ON bd.blood_type_id = bt.blood_type_id
            WHERE
                bd.user_id = $user_id";
                    

                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    // Display donor information
                    $row = mysqli_fetch_assoc($result);
                    ?>
                    <h2 class="text-center">Your Information</h2>
                    <div class="card">
                        <div class="card-body">
                            <p class="card-text"><strong>Name:</strong> <?php echo $row['Name']; ?></p>
                            <p class="card-text"><strong>Age:</strong> <?php echo $row['Age']; ?></p>
                            <p class="card-text"><strong>Gender:</strong> <?php echo $row['gender']; ?></p>
                            <p class="card-text"><strong>Address:</strong> <?php echo $row['address']; ?></p>
                            <p class="card-text"><strong>Phone:</strong> <?php echo $row['phone']; ?></p>
                            <p class="card-text"><strong>Blood Group:</strong> <?php echo $row['blood']; ?></p>
                        </div>
                    </div>
                <?php
            } else {
                echo "<p class='text-center'>No donor found with the provided ID.</p>";
            }
        } else {
            echo "<p class='text-center'>Donor ID not provided.</p>";
        }

        // Close the database connection
        mysqli_close($conn);
        ?>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>

<!-- ./CRUD_bloodDonor.php -->