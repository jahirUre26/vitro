<?php include 'session.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vitrospacio</title>
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

  <img src="images/inicio.png" class="img-fluid" alt="...">

  <div class="container mt-5">
    <div class="row text-center">
      <div class="col">
        <a href="pisos.php">
          <img src="images/piso.JPEG" class="img-fluid" alt="Pisos">
          <h3>Pisos</h3>
        </a>
      </div>
      <div class="col">
        <a href="muros.php">
          <img src="images/muro.jpg" class="img-fluid" alt="Muros">
          <h3>Muros</h3>
        </a>
      </div>
      <div class="col">
        <a href="mallas.php">
          <img src="images/malla.jpg" class="img-fluid" alt="Mallas">
          <h3>Mallas</h3>
        </a>
      </div>
      <div class="col">
        <a href="sanitarios.php">
          <img src="images/sanitario.jpg" class="img-fluid" alt="Sanitarios">
          <h3>Sanitarios</h3>
        </a>
      </div>
      <div class="col">
        <a href="lavabos.php">
          <img src="images/lavabo.jpg" class="img-fluid" alt="Lavabos">
          <h3>Lavabos</h3>
        </a>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="js/scripts.js"></script>
</body>
</html>

