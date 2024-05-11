<?php
session_start();

include 'function.php';
$conn = connectDB();

if(isset($_POST["login"])){
    $username = sanitizeInput($conn, $_POST["username"]);
    $password = sanitizeInput($conn, $_POST["password"]);

    $sql = "SELECT * FROM Users WHERE username='$username'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        
        // Hash the password using SHA-256
        $hashedPassword = hash('sha256', $password);
        $hashedPasswordLimited = substr($hashedPassword, 0, 50);
        // Compare the hashed password with the one stored in the database
        if($hashedPasswordLimited === $row['password']) {
            $_SESSION['loggedin'] = true;
            $_SESSION["username"] = $username;
            $_SESSION["role"] = $row['role'];
            $_SESSION["id"] = $row['id'];


            // check id user id exists in blood_donors table
            $userId = $row['id'];
            $donorQuery = "SELECT * FROM blood_donors WHERE user_id='$userId'";
            $donorResult = mysqli_query($conn, $donorQuery);
            if(mysqli_num_rows($donorResult) > 0) {
                // User is already in blood_donors table, set a session variable to indicate that the user is a donor
                $_SESSION['is_blood_donor'] = true;
            }

            // Check if user's id exists in contactinformation table
            $userId = $row['id'];
            $contactInfoQuery = "SELECT * FROM moneydonor WHERE user_id='$userId'";
            $contactInfoResult = mysqli_query($conn, $contactInfoQuery);

            if(mysqli_num_rows($contactInfoResult) > 0) {
                // User is already in contactinformation table, set a session variable to indicate that the user is a donor
                $_SESSION['is_donor'] = true;
            }

            $redirectUrl = ($row['role'] == 'admin') ? './admin/dashboard.php' : './home.php';
            header("Location: $redirectUrl");
            exit;
        } else {
            echo '<div class="alert alert-danger mt-3" role="alert">Incorrect password.</div>';
        }
    } else {
        echo '<div class="alert alert-danger mt-3" role="alert">User does not exist.</div>';
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>1-Life Donate & Save Lifes - Login Portal</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body style="background-image: url('Images/pg.jpg'); background-size: cover;">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card bg-light p-4">
                    <h1 class="mb-4 text-center text-danger">1-Life Donate & Save Lifes</h1>
                    <h4 class="mb-4 text-center text-info">Login Portal</h4>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <div class="form-group">
                            <label for="username">Username <span class="text-danger">*</span></label>
                            <input type="text" name="username" class="form-control" placeholder="Enter your username" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
                        </div>
                        <div class="text-center">
                            <button type="submit" name="login" class="btn btn-primary">LOGIN</button>
                        </div>
                    </form>
                    <div class="text-center mt-3">
                        <a href="./oauth_callback.php" class="btn btn-danger">
                            <i class="fab fa-google"></i> Sign In with Google
                        </a>
                    </div>
                    <div class="text-center">
                        <a href="./signup.php">Don't have an account? Sign up here</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
