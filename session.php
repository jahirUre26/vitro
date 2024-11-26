<?php
session_start();

function isUserLoggedIn() {
    return isset($_SESSION['user_id']);
}

function isAdminLoggedIn() {
    return isset($_SESSION['admin_id']);
}

function ensureUserLoggedIn() {
    if (!isUserLoggedIn()) {
        header("Location: login.php");
        exit();
    }
}

function ensureAdminLoggedIn() {
    if (!isAdminLoggedIn()) {
        header("Location: login_admin.php");
        exit();
    }
}
?>
