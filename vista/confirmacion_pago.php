<?php
session_start();

// Verificar si el pago fue exitoso
if (!isset($_SESSION['payment_success']) || !$_SESSION['payment_success']) {
    header("Location: carrito.php");
    exit();
}

// Mostrar mensaje de éxito
unset($_SESSION['payment_success']); // Limpiar sesión de pago
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago Confirmado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Fondo animado con tonos oscuros */
        body {
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #2c2c54, #706fd3, #1e272e, #485460);
            background-size: 400% 400%;
            animation: pulseBackground 8s infinite;
            color: white;
            font-family: 'Arial', sans-serif;
        }

        @keyframes pulseBackground {
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

        /* Contenedor principal */
        .confirmation-container {
            text-align: center;
            background: rgba(0, 0, 0, 0.85);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.6);
            max-width: 600px;
            width: 100%;
        }

        /* Estilo del título y texto */
        .confirmation-container h1 {
            color: #4cd137;
            font-size: 2.5rem;
            margin-bottom: 20px;
        }

        .confirmation-container p {
            color: #f5f6fa;
            font-size: 1.2rem;
            margin-bottom: 30px;
        }

        /* Botón estilizado */
        .btn-primary {
            background-color: #706fd3;
            border: none;
            font-size: 1.1rem;
            padding: 10px 20px;
        }

        .btn-primary:hover {
            background-color: #575fcf;
            box-shadow: 0px 0px 10px rgba(112, 111, 211, 0.8);
        }
    </style>
</head>
<body>

<div class="confirmation-container">
    <h1>¡Pago realizado con éxito!</h1>
    <p>Gracias por tu compra. Tu pago ha sido procesado correctamente.</p>
    <a href="home.php" class="btn btn-primary">Volver a la página principal</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
