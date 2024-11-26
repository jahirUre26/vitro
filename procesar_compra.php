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

$user_id = $_SESSION['user_id'];
$fecha = date('Y-m-d H:i:s');

// Obtener productos del carrito para el usuario logueado
$sql = "SELECT * FROM carrito WHERE user_id = '$user_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $producto_id = $row['producto_id'];
        $cantidad = $row['cantidad'];
        
        // Insertar en la tabla compras
        $insert_sql = "INSERT INTO compras (user_id, producto_id, cantidad, fecha) VALUES ('$user_id', '$producto_id', '$cantidad', '$fecha')";
        if (!$conn->query($insert_sql)) {
            die("Error al insertar en la tabla compras: " . $conn->error);
        }
        
        // Eliminar del carrito
        $delete_sql = "DELETE FROM carrito WHERE id = " . $row['id'];
        if (!$conn->query($delete_sql)) {
            die("Error al eliminar del carrito: " . $conn->error);
        }
    }
    header("Location: profile.php");
} else {
    echo "No hay productos en el carrito para procesar la compra.";
}

$conn->close();
?>
