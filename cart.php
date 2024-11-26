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

// Obtener productos del carrito para el usuario logueado
$sql = "SELECT carrito.id as carrito_id, productos.nombre, productos.precio, carrito.cantidad 
        FROM carrito 
        JOIN productos ON carrito.producto_id = productos.id 
        WHERE carrito.user_id = '$user_id'";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
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
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Inicio</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="productos.php">Productos <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contacto.php">Contacto</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <?php if (isUserLoggedIn()): ?>
                    <li class="nav-item"><a class="nav-link" href="profile.php">Perfil</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout_us.php">Cerrar Sesión</a></li>
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

    <div class="container mt-5">
        <h2>Carrito de Compras</h2>
        <form method="post" action="procesar_compra.php">
            <?php
            if ($result->num_rows > 0) {
                echo "<table class='table'>";
                echo "<thead><tr><th>Producto</th><th>Precio</th><th>Cantidad</th><th>Total</th><th>Acciones</th></tr></thead>";
                echo "<tbody>";
                $total = 0;
                while($row = $result->fetch_assoc()) {
                    $subtotal = $row["precio"] * $row["cantidad"];
                    $total += $subtotal;
                    echo "<tr>";
                    echo "<td>" . $row["nombre"] . "</td>";
                    echo "<td>$" . $row["precio"] . "</td>";
                    echo "<td>" . $row["cantidad"] . "</td>";
                    echo "<td>$" . $subtotal . "</td>";
                    echo "<td><a href='eliminar_carrito.php?id=" . $row["carrito_id"] . "' class='btn btn-danger btn-sm'>Eliminar</a></td>";
                    echo "</tr>";
                }
                echo "<tr><td colspan='3' class='text-right'><strong>Total</strong></td><td><strong>$" . $total . "</strong></td></tr>";
                echo "</tbody>";
                echo "</table>";
                echo "<button type='submit' class='btn btn-primary' name='realizar_compra'>Realizar Compra</button>";
            } else {
                echo "<p>No hay productos en el carrito.</p>";
            }
            ?>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="js/scripts.js"></script>
</body>
</html>

