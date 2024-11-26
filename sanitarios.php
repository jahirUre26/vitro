<?php include 'session.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos de Sanitarios</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="index.php">
      <img src="images/logo.png" width="30" height="30" class="d-inline-block align-top" alt="Logo de la empresa">
      Vitrospacio
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="index.php">Inicio <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="productos.php">Productos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="contacto.php">Contacto</a>
        </li>
      </ul>
      <ul class="navbar-nav ml-auto">
        <?php if (isset($_SESSION['user_id'])): ?>
          <li class="nav-item"><a class="nav-link" href="profile.php">Perfil</a></li>
          <li class="nav-item"><a class="nav-link" href="logout.php">Cerrar Sesión</a></li>
          <li class="nav-item">
            <a class="nav-link" href="cart.php">
              <img src="images/carrito.png" width="20" height="20" alt="Carrito de compra">
            </a>
          </li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link" href="login_us.php">Inicio de Sesión</a></li>
          <li class="nav-item"><a class="nav-link" href="register_us.php">Registro</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </nav>
<div class="container">
    <h1>Productos de Sanitarios</h1>
    <?php
    // Conectar a la base de datos
    $conn = new mysqli('localhost', 'root', '', 'tienda');

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Consulta SQL para obtener los productos de la categoría de Pisos
    $sql = "SELECT id, nombre, imagen FROM productos WHERE categoria_id = '4'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Mostrar los nombres de los productos con un enlace al detalle
        while($row = $result->fetch_assoc()) {
            echo "<div class='producto'>";
            echo "<a href='detalle_producto.php?id=" . $row["id"] . "'>";
            echo "<img src='" . $row["imagen"] . "' alt='" . $row["nombre"] . "' class='img-fluid'>";
            echo "<h3>" . $row["nombre"] . "</h3>";
            echo "</a>";
            echo "<a href='agregar_carrito.php?id=" . $row["id"] . "' class='btn btn-primary'>Agregar al carrito</a>";
            echo "</div>";
        }
    } else {
        echo "No se encontraron productos en esta categoría.";
    }

    $conn->close();
    ?>
</div>
<!-- Scripts -->
</body>
</html>
