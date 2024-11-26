<?php include 'session.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Admin - Agregar Producto</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            max-width: 600px;
            margin-top: 50px;
        }
        .logo {
            max-height: 50px;
        }
        .alert {
            margin-top: 20px;
        }
        .color-input-group {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        .color-input-group input[type="text"] {
            flex: 1;
            margin-right: 10px;
        }
        .color-input-group input[type="file"] {
            flex: 2;
        }
        .add-color-btn, .remove-color-btn {
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="admin_home.php">
            <img src="images/logo.png" alt="Logo" class="logo">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="admin_home.php">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="vendedores_admin.php">Vendedores</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Cerrar Sesión</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container mt-5">
        <h2>Agregar Producto</h2>
        <?php
        // Conectar a la base de datos
        $conn = new mysqli('localhost', 'root', '', 'tienda');

        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $precio = $_POST['precio'];
            $categoria_id = $_POST['categoria_id'];
            $stock = isset($_POST['stock']) ? 1 : 0;

            // Manejar la subida del archivo de imagen
            $imagen_nombre = $_FILES['imagen']['name'];
            $imagen_tmp = $_FILES['imagen']['tmp_name'];
            $imagen_tamano = $_FILES['imagen']['size'];
            $imagen_tipo = $_FILES['imagen']['type'];

            $imagen_ext = pathinfo($imagen_nombre, PATHINFO_EXTENSION);
            $imagen_nueva = uniqid() . '.' . $imagen_ext;
            $imagen_destino = 'uploads/' . $imagen_nueva;

            // Mover la imagen subida a la carpeta de destino
            if (move_uploaded_file($imagen_tmp, $imagen_destino)) {
                // Guardar los datos del producto en la base de datos
                $sql = "INSERT INTO productos (nombre, descripcion, precio, imagen, stock, categoria_id) VALUES ('$nombre', '$descripcion', '$precio', '$imagen_destino', '$stock', '$categoria_id')";

                if ($conn->query($sql) === TRUE) {
                    $producto_id = $conn->insert_id;

                    // Insertar colores si hay
                    if (isset($_POST['colores'])) {
                        foreach ($_POST['colores'] as $index => $color) {
                            $color_nombre = $color['nombre'];
                            $color_imagen = $_FILES['colores']['name'][$index]['imagen'];
                            $color_tmp = $_FILES['colores']['tmp_name'][$index]['imagen'];
                            $color_ext = pathinfo($color_imagen, PATHINFO_EXTENSION);
                            $color_nueva = uniqid() . '.' . $color_ext;
                            $color_destino = 'uploads/' . $color_nueva;

                            if (move_uploaded_file($color_tmp, $color_destino)) {
                                $sql_color = "INSERT INTO colores (producto_id, color_nombre, color_imagen) VALUES ('$producto_id', '$color_nombre', '$color_destino')";
                                $conn->query($sql_color);
                            }
                        }
                    }

                    echo "<div class='alert alert-success'>Producto agregado con éxito</div>";
                } else {
                    echo "<div class='alert alert-danger'>Error: " . $sql . "<br>" . $conn->error . "</div>";
                }
            } else {
                echo "<div class='alert alert-danger'>Error al subir la imagen.</div>";
            }
        }

        // Obtener categorías para el formulario
        $sql = "SELECT * FROM categorias";
        $categorias = $conn->query($sql);

        $conn->close();
        ?>
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nombre">Nombre del Producto</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="precio">Precio</label>
                <input type="number" step="0.01" class="form-control" id="precio" name="precio" required>
            </div>
            <div class="form-group">
                <label for="imagen">Imagen del Producto</label>
                <input type="file" class="form-control-file" id="imagen" name="imagen" required>
            </div>
            <div class="form-group">
                <label for="categoria_id">Categoría</label>
                <select class="form-control" id="categoria_id" name="categoria_id" required>
                    <?php
                    if ($categorias->num_rows > 0) {
                        while($row = $categorias->fetch_assoc()) {
                            echo "<option value='" . $row['id'] . "'>" . $row['nombre'] . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="stock" name="stock">
                <label class="form-check-label" for="stock">En stock</label>
            </div>
            <h3>Colores del Producto</h3>
            <div id="colores-container">
                <div class="color-input-group">
                    <input type="text" class="form-control" name="colores[0][nombre]" placeholder="Nombre del color" required>
                    <input type="file" class="form-control-file" name="colores[0][imagen]" required>
                    <button type="button" class="btn btn-danger remove-color-btn">Eliminar</button>
                </div>
            </div>
            <button type="button" class="btn btn-primary add-color-btn">Agregar Color</button>
            <br><br>
            <button type="submit" class="btn btn-primary mt-3">Agregar Producto</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function () {
            let colorIndex = 1;

            $('.add-color-btn').click(function () {
                const colorInputGroup = `
                    <div class="color-input-group">
                        <input type="text" class="form-control" name="colores[${colorIndex}][nombre]" placeholder="Nombre del color" required>
                        <input type="file" class="form-control-file" name="colores[${colorIndex}][imagen]" required>
                        <button type="button" class="btn btn-danger remove-color-btn">Eliminar</button>
                    </div>`;
                $('#colores-container').append(colorInputGroup);
                colorIndex++;
            });

            $('#colores-container').on('click', '.remove-color-btn', function () {
                $(this).parent().remove();
            });
        });
    </script>
</body>
</html>