<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: public/login.php");
} elseif ($_SESSION['admin']) {
    header("Location: ../management.php");
} else 
    header("Location: ../scanner.php ");
?>