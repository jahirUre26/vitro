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

// Obtener datos del usuario
$sql = "SELECT nombre, email FROM usuarios WHERE id = '$user_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user_data = $result->fetch_assoc();
} else {
    echo "Usuario no encontrado";
    exit();
}

// Obtener historial de compras
$sql_compras = "SELECT id, producto_id, cantidad, fecha FROM compras WHERE user_id = '$user_id'";
$result_compras = $conn->query($sql_compras);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <style>
        .profile-container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .profile-header {
            margin-bottom: 20px;
        }
        .profile-header h2 {
            font-weight: bold;
            color: #343a40;
        }
        .profile-info p {
            font-size: 1.1em;
        }
        .btn-custom {
            background-color: #007bff;
            color: white;
        }
        .btn-custom:hover {
            background-color: #0056b3;
        }
        #editForm {
            display: none;
            margin-top: 20px;
            padding: 20px;
            background: #ffffff;
            border: 1px solid #ced4da;
            border-radius: 10px;
        }
        .table-custom {
            background: #ffffff;
            border: 1px solid #dee2e6;
            border-radius: 10px;
        }
        .table-custom th {
            background: #007bff;
            color: white;
        }
    </style>
    <script>
        function toggleEditForm() {
            var form = document.getElementById('editForm');
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        }
    </script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="inicio.php">
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
                <li class="nav-item">
                    <a class="nav-link" href="productos.php">Productos</a>
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

    <div class="container mt-5 profile-container">
        <div class="profile-header">
            <h2>Perfil de Usuario</h2>
        </div>
        <div class="profile-info">
            <p><strong>Nombre:</strong> <?php echo $user_data['nombre']; ?></p>
            <p><strong>Correo Electrónico:</strong> <?php echo $user_data['email']; ?></p>
        </div>
        <button class="btn btn-custom" onclick="toggleEditForm()">Modificar Datos</button>

        <div id="editForm">
            <form action="editar_perfil.php" method="post">
                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $user_data['nombre']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Correo Electrónico:</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $user_data['email']; ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            </form>
        </div>

        <div class="mt-5">
            <h3>Historial de Compras</h3>
            <?php
            if ($result_compras->num_rows > 0) {
                echo "<table class='table table-custom'>";
                echo "<thead><tr><th>ID</th><th>Producto</th><th>Cantidad</th><th>Fecha</th></tr></thead>";
                echo "<tbody>";
                while ($row = $result_compras->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . $row["producto"] . "</td>";
                    echo "<td>" . $row["cantidad"] . "</td>";
                    echo "<td>" . $row["fecha"] . "</td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
            } else {
                echo "<p>No hay compras registradas.</p>";
            }
            ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
