<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <!-- Enlace a Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/login.css"> <!-- Cambia 'el nombre del archivo.css' al nombre correcto de tu archivo CSS -->
</head>
<body>
<div class="container">
    <div class="login-container">
        <h2 class="text-center">Iniciar Sesión</h2>
        <form action="../controlador/LoginController.php" method="POST" autocomplete="off">
            <div class="form-group">
                <label for="username">Usuario:</label>
                <input type="text" name="username" class="form-control" required placeholder="Ingresa tu usuario" aria-label="Usuario" autofocus>
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" name="password" class="form-control" required placeholder="Ingresa tu contraseña" aria-label="Contraseña">
            </div>
            <button type="submit" name="action" value="login" class="btn btn-primary btn-block">Iniciar Sesión</button>
        </form>
        <br>
        <button type="button" class="btn btn-primary btn-block" onclick="location.href='../vista/registro.php'">Registrarse</button>
        <br>
        <button type="button" class="btn btn-primary btn-block" onclick="location.href='../vista/recuperar.php'">Recuperar contraseña</button>
        <?php
        session_start();
        if (isset($_SESSION['error'])) {
            echo "<p class='text-danger text-center mt-3'>" . $_SESSION['error'] . "</p>";
            echo "<script>document.querySelectorAll('.form-control').forEach(el => el.classList.add('is-invalid'));</script>";
            unset($_SESSION['error']);
        }
        ?>
    </div>
</div>

<!-- Enlace a Bootstrap JS y dependencias -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
