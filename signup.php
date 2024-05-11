<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>1-Life Donate & Save Lifes - Create Account</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body style="background-image: url('Images/pg.jpg'); background-size: cover;">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card bg-light p-4">
                    <h1 class="mb-4 text-center text-danger">1-Life Donate & Save Lifes</h1>
                    <h4 class="mb-4 text-center text-info">Create Account</h4>
                    <form action="process_create_account.php" method="post">
                        <div class="form-group">
                            <label for="username">Username <span class="text-danger">*</span></label>
                            <input type="text" name="username" class="form-control" placeholder="Enter your username" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                        </div>
                        <div class="text-center">
                            <button type="submit" name="create_account" class="btn btn-primary">Create Account</button>
                        </div>
                    </form>
                    <div class="text-center mt-3">
                        <a href="./oauth_callback.php" class="btn btn-danger">
                            <i class="fab fa-google"></i> Sign Up with Google
                        </a>                       
                    </div>
                    <div class="text-center">
                        <a href="./Login.php">Already have an account</a>
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
