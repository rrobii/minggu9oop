<?php
session_start();
require_once 'User.php';

if (!isset($_SESSION['id']) || $_SESSION['level'] != 1) {
    header("location:login.php");
    exit();
}

if (isset($_GET['id'])) {
    $user = new User();
    $result = $user->deleteUser($_GET['id']);
    
    if ($result === true) {
        header("location:home.php");
        exit();
    } else {
        echo $result;
    }
} else {
    header("location:home.php");
    exit();
}
?>