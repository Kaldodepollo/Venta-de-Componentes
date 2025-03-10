<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/registro.css">
</head>
<body>
<body>
    <div class="container">
        <h2>Registrar Cuenta</h2>
        <form action="../controlador/RegistroController.php" method="POST" class="form" id="registerForm">
            <div class="alert" id="alert">Las contraseñas no coinciden. Por favor, verifica.</div>
            <label for="username">Usuario:</label>
            <input type="text" name="username" id="username" required>

            <label for="email">Correo Electrónico:</label>
            <input type="email" name="email" id="email" required>

            <label for="phone">Teléfono:</label>
            <input type="text" name="phone" id="phone" required>

            <label for="password">Contraseña:</label>
            <input type="password" name="password" id="password" required>

            <label for="confirm_password">Confirmar Contraseña:</label>
            <input type="password" name="confirm_password" id="confirm_password" required>

            <button type="submit">Registrar</button>
            <a href="login.php">
            <button type="button" class="btn btn-primary btn-block">Ir a Iniciar Sesión</button>
        </a>
        </form>
    </div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    // Validación de contraseñas con JavaScript antes de enviar el formulario
    document.getElementById("registerForm").addEventListener("submit", function(event) {
        const password = document.querySelector("input[name='password']").value;
        const confirmPassword = document.querySelector("input[name='confirm_password']").value;

        if (password !== confirmPassword) {
            event.preventDefault(); // Detener envío
            alert("Las contraseñas no coinciden. Por favor, verifica.");
        }
    });
</script>
</body>
</html>
