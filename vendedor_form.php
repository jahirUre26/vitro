<?php
$id = '';
$usuario = '';
$contrasena = '';

if (isset($_GET['id'])) {
    // Editar vendedor
    $conn = new mysqli('localhost', 'root', '', 'tienda');

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $id = $_GET['id'];
    $sql = "SELECT * FROM vendedores WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $usuario = $row['usuario'];
        $contrasena = $row['contrasena'];
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $id ? 'Editar Vendedor' : 'Agregar Vendedor'; ?></title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="text-center"><?php echo $id ? 'Editar Vendedor' : 'Agregar Vendedor'; ?></h1>
        <form action="<?php echo $id ? 'update_vendedor.php' : 'add_vendedor.php'; ?>" method="POST">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="form-group">
                <label for="usuario">Usuario</label>
                <input type="text" class="form-control" id="usuario" name="usuario" value="<?php echo $usuario; ?>" required>
            </div>
            <div class="form-group">
                <label for="contrasena">Contraseña</label>
                <input type="password" class="form-control" id="contrasena" name="contrasena" value="<?php echo $contrasena; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary"><?php echo $id ? 'Actualizar' : 'Agregar'; ?></button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
