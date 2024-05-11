<?php
require_once 'vendor/autoload.php';
require_once 'function.php'; // Include your function.php file
session_start();

// Function to establish a database connection
$conn = connectDB();


$redirectUri = 'http://localhost/1-life-main/home.php'; // Change the redirect URI to signup_oauth.php

// create Client Request to access Google API
$client = new Google_Client();
$client->setClientSecret($clientSecret);
$client->addScope("email");
$client->addScope("profile");

// authenticate code from Google OAuth Flow
if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token['access_token']);

    // get profile info
    $google_oauth = new Google_Service_Oauth2($client);
    $google_account_info = $google_oauth->userinfo->get();

    $userinfo = [
        'name' => $google_account_info['givenName'],
        'email' => $google_account_info['email']   
    ];
    $sql = "SELECT * FROM users WHERE email= '{$userinfo['email']}'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0){
        $userdata= mysqli_fetch_assoc($result);
    } else{
        $sql = "INSERT INTO users (username, email, role) VALUES ('{$userinfo['givenName']}', '{$userinfo['email']}', 'user')";
        $result = mysqli_query($conn, $sql);
        if($result){
            // Redirect to home page after successful signup
            header("Location: ./home.php");
            exit;
        } else{
            echo "Error: " . $stmt->error;
            die();
        }
    }
} else {
    // Redirect to Google OAuth authentication page
    header("Location: " . $client->createAuthUrl());
    exit;
}
?>
