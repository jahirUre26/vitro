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
    $producto_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    // Verificar si el producto ya está en el carrito
    $sql = "SELECT * FROM carrito WHERE producto_id = '$producto_id' AND user_id = '$user_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Si el producto ya está en el carrito, aumentar la cantidad
        $sql = "UPDATE carrito SET cantidad = cantidad + 1 WHERE producto_id = '$producto_id' AND user_id = '$user_id'";
    } else {
        // Si el producto no está en el carrito, agregarlo
        $sql = "INSERT INTO carrito (user_id, producto_id, cantidad) VALUES ('$user_id', '$producto_id', 1)";
    }

    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success'>Producto agregado al carrito.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $sql . "<br>" . $conn->error . "</div>";
    }
}

$conn->close();

// Redirigir al usuario a la página del carrito
header("Location: cart.php");
exit();
?>
