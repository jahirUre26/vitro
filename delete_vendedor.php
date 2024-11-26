<?php
if (isset($_GET['id'])) {
    $conn = new mysqli('localhost', 'root', '', 'tienda');

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $id = $_GET['id'];
    $sql = "DELETE FROM vendedores WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        header("Location: vendedores_admin.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
