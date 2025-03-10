<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/contravista.css">
    <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
                /* Fondo animado con degradado de negro a gris */
                body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(120deg, #000000, #4d4d4d);
            background-size: 400% 400%;
            animation: animateBackground 6s infinite;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white; /* Asegura que el texto sea legible */
        }

        /* Animación del fondo */
        @keyframes animateBackground {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }

        /* Contenedor del formulario */
        .container {
            max-width: 600px;
            padding: 30px;
            background: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            color: black; /* Asegura que el texto interno sea visible */
        }

        /* Botón personalizado */
        .btn-custom {
            background-color: #772ce8;
            color: white;
        }

        .btn-custom:hover {
            background-color: #772ce8;
        }
    </style>
</head>
<body>
    <div class="container text-center">
        <h1 class="mb-4">Recuperación de Contraseña</h1>
        <?php if (isset($mensaje) && isset($tipo)): ?>
            <div class="alert alert-<?= htmlspecialchars($tipo) ?> text-center">
                <?= $mensaje ?>
            </div>
        <?php else: ?>
            <p>Introduce los datos necesarios para recuperar tu contraseña.</p>
        <?php endif; ?>
        <div class="text-center mt-3">
            <button onclick="location.href='../vista/login.php'" class="btn btn-custom">Regresar al Inicio de Sesión</button>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
