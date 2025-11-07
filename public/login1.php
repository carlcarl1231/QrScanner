<?php
session_start();


$valid_username = "admin";
$valid_password = "password";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];


    if ($username === $valid_username && $password === $valid_password) {

        $_SESSION['username'] = $username;
        $_SESSION['logged_in'] = true;
        header("Location: index.php"); 
        exit();
    } else {
 
        $_SESSION['error'] = "Invalid username or password.";
        header("Location: login.php"); 
        exit();
    }
}
?>
