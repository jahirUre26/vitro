<?php
// Función para verificar si el usuario es administrador
function isAdmin() {
    if (!isset($_SESSION['user_id'])) {
        return false;
    }

    // Conectar a la base de datos
    $conn = new mysqli('localhost', 'root', '', 'tienda');

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $user_id = $_SESSION['user_id'];
    $sql = "SELECT rol FROM usuarios WHERE id = '$user_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['rol'] === 'admin';
    }

    return false;
}
?>
