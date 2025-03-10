<?php
session_start();

// Verificar si el carrito está vacío
if (empty($_SESSION['cart'])) {
    header("Location: carrito.php");
    exit();
}

// Calcular el total del carrito
$total = 0;
foreach ($_SESSION['cart'] as $item) {
    $total += $item['precio'] * $item['quantity']; // Calcula el total sumando los precios por las cantidades
}

// Si el formulario de pago se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Guardamos los datos de la tarjeta en la sesión (esto es solo un ejemplo, no es seguro para producción)
    $_SESSION['payment'] = [
        'tarjeta_numero' => $_POST['tarjeta_numero'],
        'tarjeta_expiracion' => $_POST['tarjeta_expiracion'],
        'tarjeta_codigo' => $_POST['tarjeta_codigo']
    ];

    // Eliminar los productos del carrito después del pago
    unset($_SESSION['cart']); // Esto elimina todo el carrito

    // Mostrar mensaje de éxito
    $_SESSION['payment_success'] = true;
    header("Location: confirmacion_pago.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Pago</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Fondo animado con pulso */
        body {
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(45deg, #2c2c54, #706fd3, #1e272e, #485460);
            background-size: 400% 400%;
            animation: pulseBackground 8s infinite;
            color: white;
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

        /* Estilo del formulario */
        .form-container {
            background: rgba(0, 0, 0, 0.85);
            padding: 20px 30px;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.6);
            max-width: 400px;
            width: 100%;
        }

        .form-container h2 {
            color: #fff;
            text-align: center;
        }

        .form-container label {
            color: #ccc;
        }

        .form-container .form-control {
            background-color: #333;
            color: #fff;
            border: 1px solid #555;
        }

        .form-container .form-control:focus {
            background-color: #444;
            color: #fff;
            border-color: #706fd3;
            box-shadow: 0 0 0 0.2rem rgba(112, 111, 211, 0.5);
        }

        .btn-primary {
            background-color: #706fd3;
            border: none;
        }

        .btn-primary:hover {
            background-color: #575fcf;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Formulario de Pago</h2>

    <!-- Mostrar el total a pagar -->
    <p class="text-center fs-5">Total a Pagar: <span class="text-info">$<?php echo number_format($total, 2); ?></span></p>

    <!-- Formulario de pago -->
    <form action="formulario_pago.php" method="POST">
        <div class="mb-3">
            <label for="tarjeta_numero" class="form-label">Número de tarjeta:</label>
            <input type="text" class="form-control" name="tarjeta_numero" id="tarjeta_numero" placeholder="XXXX-XXXX-XXXX-XXXX" required>
        </div>
        <div class="mb-3">
            <label for="tarjeta_expiracion" class="form-label">Fecha de expiración:</label>
            <input type="month" class="form-control" name="tarjeta_expiracion" id="tarjeta_expiracion" required>
        </div>
        <div class="mb-3">
            <label for="tarjeta_codigo" class="form-label">Código de seguridad (CVV):</label>
            <input type="text" class="form-control" name="tarjeta_codigo" id="tarjeta_codigo" placeholder="XXX" maxlength="3" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Realizar Pago</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
