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

// Obtener datos del formulario
$nombre = $_POST['nombre'];
$email = $_POST['email'];

// Actualizar datos del usuario
$sql_update = "UPDATE usuarios SET nombre = ?, email = ? WHERE id = ?";
$stmt = $conn->prepare($sql_update);
$stmt->bind_param('ssi', $nombre, $email, $user_id);

if ($stmt->execute()) {
    // Redirigir al perfil después de actualizar
    header("Location: profile.php");
} else {
    echo "Error al actualizar el perfil: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
