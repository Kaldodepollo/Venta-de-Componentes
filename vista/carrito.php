<?php
session_start();

// Verificar si el carrito existe, si no inicializarlo
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Manejo del cierre de sesión
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}

// Calcular el total del carrito
$total = array_sum(array_map(function($item) {
    return $item['precio'] * $item['quantity'];
}, $_SESSION['cart']));
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
    <a class="navbar-brand" href="home.php"><i class="bi bi-basket3"></i> TechWarriors</a>
    <div class="ml-auto d-flex align-items-center">
        <span class="navbar-text text-white me-3">
            Hola, <?php echo htmlspecialchars($_SESSION['username'] ?? 'Usuario'); ?>
        </span>

        <!-- Carrito -->
        <div class="dropdown me-3">
            <button class="btn btn-outline-light dropdown-toggle" type="button" id="cartDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-cart"></i> Carrito (<?php echo count($_SESSION['cart']); ?>) - $<?php echo number_format($total, 2); ?>
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="cartDropdown">
                <?php if (empty($_SESSION['cart'])): ?>
                    <li><span class="dropdown-item text-muted">Tu carrito está vacío</span></li>
                <?php else: ?>
                    <li><a class="dropdown-item" href="carrito.php">Ver carrito</a></li>
                <?php endif; ?>
            </ul>
        </div>

        <!-- Usuario -->
        <div class="dropdown">
            <button class="btn btn-outline-light dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <?php echo ($_SESSION['role'] ?? '') === 'admin' ? 'Admin' : 'Usuario'; ?>
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                <li><a class="dropdown-item" href="?logout=true">Cerrar sesión</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Carrito -->
<div class="container mt-5">
    <h1 class="text-center mb-4">Tu Carrito</h1>
    <div class="table-responsive">
        <table class="table table-bordered align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION['cart'] as $id => $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['nombre']); ?></td>
                        <td><?php echo $item['quantity']; ?></td>
                        <td>$<?php echo number_format($item['precio'], 2); ?></td>
                        <td>$<?php echo number_format($item['precio'] * $item['quantity'], 2); ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr class="table-light">
                    <td colspan="3" class="text-end fw-bold">Total:</td>
                    <td class="fw-bold">$<?php echo number_format($total, 2); ?></td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Botón para proceder al pago -->
    <div class="text-center mt-4">
        <a href="formulario_pago.php?total=<?php echo $total; ?>" class="btn btn-success btn-lg">
            <i class="bi bi-cash-stack"></i> Proceder al Pago
        </a>
    </div>
</div>

<!-- Bootstrap JS y dependencias -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
