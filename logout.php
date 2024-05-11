// Logout script
<?php session_start();

// Unset or destroy the is_donor session variable
unset($_SESSION['is_donor']);

// Destroy all other session variables
session_destroy();

// Redirect the user to the login page or any other appropriate page
header("Location: login.php");
exit();
?>