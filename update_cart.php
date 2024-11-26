<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productId = $_POST['product_id'];
    if (isset($_POST['action']) && $_POST['action'] == 'remove') {
        unset($_SESSION['cart'][$productId]);
    } else {
        $quantity = $_POST['quantity'];
        $_SESSION['cart'][$productId]['quantity'] = $quantity;
    }
}

header("Location: cart.php");
exit();
?>
