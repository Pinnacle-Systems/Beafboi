<?php

if (isset($condition) && $condition == true) {
    session_start();
    if (isset($_SESSION['email']) && isset($_SESSION['token'])) {
        $email = $_SESSION['email'];
        $token = $_SESSION['token'];
        include_once('managers/admin_manager.php');
        if (isvalidAdminToken($email, $token)) {
            $admin = getAdminByEmail($email);
        } else {
            unset($_SESSION['email']);
            unset($_SESSION['token']);
            exit(header("location:login.php"));
        }
    } else {
        exit(header("location:login.php"));
    }
} else {
    exit(header("location:404.php"));
}
?>