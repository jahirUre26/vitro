<?php
include 'session.php';

// Verificar si el usuario está logueado
if (!isUserLoggedIn()) {
    header("Location: login.php");
    exit();
}

// Conectar a la base de datos
$conn = new mysqli('localhost', 'root', '', 'tienda');

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $carrito_id = $_GET['id'];

    // Eliminar el producto del carrito
    $sql = "DELETE FROM carrito WHERE id = '$carrito_id'";

    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success'>Producto eliminado del carrito.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $sql . "<br>" . $conn->error . "</div>";
    }
}

$conn->close();

// Redirigir al usuario a la página del carrito
header("Location: cart.php");
exit();
?>
