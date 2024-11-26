<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = new mysqli('localhost', 'root', '', 'tienda');

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $usuario = $_POST['usuario'];
    $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO vendedores (usuario, contrasena) VALUES ('$usuario', '$contrasena')";

    if ($conn->query($sql) === TRUE) {
        header("Location: vendedores_admin.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
