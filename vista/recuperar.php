<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/recuperarcontraseña.css">
</head>
<body>
    <div class="container">
        <h2>Recuperar Contraseña</h2>
        <form action="../controlador/RecuperarController.php" method="POST" class="card p-4 shadow">
            <div class="form-group">
                <label for="email">Correo Electrónico:</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="phone">Teléfono:</label>
                <input type="text" name="phone" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="username">Usuario:</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Recuperar</button>
            <br>
            <a href="login.php">
            <button type="button" class="btn btn-primary btn-block">Ir a Iniciar Sesión</button>
        </a>
    </div>
        </form>
    </div>
    

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
