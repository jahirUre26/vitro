<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del Producto</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <style>
        .color-thumbnail {
            width: 50px;
            height: 50px;
            margin-right: 10px;
            cursor: pointer;
        }
        .selected-color {
            border: 2px solid #007bff; /* Cambiar el color según tu estilo */
        }
        .color-thumbnails {
            margin-top: 20px;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <!-- Navbar code -->
</nav>
<div class="container">
    <?php
    // Verificar si se ha proporcionado un ID de producto válido
    if (isset($_GET['id']) && !empty($_GET['id'])) {
      $producto_id = $_GET['id'];


        // Conectar a la base de datos
        $conn = new mysqli('localhost', 'root', '', 'tienda');

        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        // Consulta SQL para obtener los detalles del producto
        $sql = "SELECT * FROM productos WHERE id = '$producto_id'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Mostrar los detalles del producto
            $row = $result->fetch_assoc();
            echo "<div class='row'>";
            echo "<div class='col-md-6'>";
            echo "<img id='imagen-principal' src='{$row['imagen']}' alt='{$row['nombre']}' class='img-fluid'>";
            echo "</div>";
            echo "<div class='col-md-6'>";
            echo "<h1>{$row['nombre']}</h1>";
            echo "<p><strong>Descripción:</strong></p>";
            echo "<ul>";
            $descripciones = explode("\n", $row['descripcion']);
            foreach ($descripciones as $descripcion) {
                echo "<li>$descripcion</li>";
            }
            echo "</ul>";
            echo "<p><strong>Precio:</strong> $ {$row['precio']}</p>";
            echo "<button class='btn btn-primary' id='agregar-carrito'>Agregar al carrito</button>"; // Añadí un ID al botón
            echo "</div>";
            echo "</div>";
            echo "<div class='row'>";
            echo "<div class='col-md-6'>";
            
            // Consulta SQL para obtener los colores del producto
            $sql_colores = "SELECT * FROM colores WHERE producto_id = '$producto_id'";
            $result_colores = $conn->query($sql_colores);

            if ($result_colores->num_rows > 0) {
                echo "<h2>Colores disponibles</h2>";
                echo "<div class='color-thumbnails'>";
                while ($color = $result_colores->fetch_assoc()) {
                    echo "<img src='{$color['color_imagen']}' alt='{$color['color_nombre']}' class='img-fluid color-thumbnail' data-imagen='{$color['color_imagen']}'>";
                }
                echo "</div>";
            } else {
                echo "<p>No hay colores disponibles para este producto.</p>";
            }
            echo "</div>";
            echo "</div>";
        } else {
            echo "No se encontró el producto.";
        }

        $conn->close();
    } else {
        echo "ID de producto no válido.";
    }
    ?>
</div>
<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    // Script para cambiar la imagen principal al hacer clic en las miniaturas de color
    const colorThumbnails = document.querySelectorAll('.color-thumbnail');
    const imagenPrincipal = document.getElementById('imagen-principal');

    colorThumbnails.forEach(thumbnail => {
        thumbnail.addEventListener('click', () => {
            const nuevaImagen = thumbnail.getAttribute('data-imagen');
            imagenPrincipal.src = nuevaImagen;

            // Remover la clase 'selected-color' de todas las miniaturas y agregarla solo a la seleccionada
            colorThumbnails.forEach(item => item.classList.remove('selected-color'));
            thumbnail.classList.add('selected-color');
        });
    });

    // Script para manejar el clic en el botón "Agregar al carrito"
    document.getElementById('agregar-carrito').addEventListener('click', function () {
        // Aquí puedes agregar la lógica para agregar el producto al carrito
        alert('Producto agregado al carrito');
    });
</script>
</body>
</html>
