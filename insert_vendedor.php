<?php
// Conectar a la base de datos
$conn = new mysqli('localhost', 'root', '', 'tienda');

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Datos del nuevo vendedor
$usuario = 'admin';
$contrasena = 'admin123';

// Hashear la contraseña
$hashedPassword = password_hash($contrasena, PASSWORD_DEFAULT);

// Inserción del nuevo vendedor
$sql = "INSERT INTO vendedores (usuario, contrasena) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $usuario, $hashedPassword);

if ($stmt->execute()) {
    echo "Nuevo vendedor insertado correctamente.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$stmt->close();
$conn->close();
?>
