<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = new mysqli('localhost', 'root', '', 'tienda');

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $id = $_POST['id'];
    $usuario = $_POST['usuario'];
    $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);

    $sql = "UPDATE vendedores SET usuario = '$usuario', contrasena = '$contrasena' WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        header("Location: vendedores_admin.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
