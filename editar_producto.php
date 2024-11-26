<?php
include 'session.php';

// Conectar a la base de datos
$conn = new mysqli('localhost', 'root', '', 'tienda');
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener el ID del producto a editar
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Obtener los datos del producto
    $sql = "SELECT * FROM productos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $producto = $result->fetch_assoc();

    if (!$producto) {
        die("Producto no encontrado.");
    }
} else {
    die("ID de producto no especificado.");
}

// Procesar el formulario de edición
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $imagen = $_POST['imagen'];
    $stock = $_POST['stock'];
    $categoria_id = $_POST['categoria_id'];

    $sql = "UPDATE productos SET nombre = ?, descripcion = ?, precio = ?, imagen = ?, stock = ?, categoria_id = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdsiii", $nombre, $descripcion, $precio, $imagen, $stock, $categoria_id, $id);

    if ($stmt->execute()) {
        header("Location: productos_admin.php");
        exit();
    } else {
        echo "Error al actualizar el producto: " . $stmt->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            margin-top: 50px;
        }
        .form-group {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1 class="text-center">Editar Producto</h1>
    <form method="POST">
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($producto['nombre']); ?>" required>
        </div>
        <div class="form-group">
            <label for="descripcion">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" required><?php echo htmlspecialchars($producto['descripcion']); ?></textarea>
        </div>
        <div class="form-group">
            <label for="precio">Precio</label>
            <input type="number" step="0.01" class="form-control" id="precio" name="precio" value="<?php echo htmlspecialchars($producto['precio']); ?>" required>
        </div>
        <div class="form-group">
            <label for="imagen">URL de la Imagen</label>
            <input type="text" class="form-control" id="imagen" name="imagen" value="<?php echo htmlspecialchars($producto['imagen']); ?>" required>
        </div>
        <div class="form-group">
            <label for="stock">Stock</label>
            <input type="number" class="form-control" id="stock" name="stock" value="<?php echo htmlspecialchars($producto['stock']); ?>" required>
        </div>
        <div class="form-group">
            <label for="categoria_id">Categoría</label>
            <input type="number" class="form-control" id="categoria_id" name="categoria_id" value="<?php echo htmlspecialchars($producto['categoria_id']); ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar Producto</button>
    </form>
</div>
</body>
</html>
