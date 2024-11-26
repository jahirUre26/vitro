<?php
include 'session.php';


// Conectar a la base de datos
$conn = new mysqli('localhost', 'root', '', 'tienda');
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener el ID del producto a eliminar
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Verificar si el producto existe en compras
    $sqlCheck = "SELECT * FROM compras WHERE producto_id = ?";
    $stmtCheck = $conn->prepare($sqlCheck);
    $stmtCheck->bind_param("i", $id);
    $stmtCheck->execute();
    $resultCheck = $stmtCheck->get_result();

    if ($resultCheck->num_rows > 0) {
        echo "No se puede eliminar el producto porque está asociado a una compra.";
    } else {
        // Eliminar el producto
        $sql = "DELETE FROM productos WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            header("Location: productos_admin.php");
            exit();
        } else {
            echo "Error al eliminar el producto: " . $stmt->error;
        }
    }
} else {
    echo "ID de producto no especificado.";
}

$conn->close();
?>
