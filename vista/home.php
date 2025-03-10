<?php
session_start();
require_once(__DIR__ . '/../controlador/componenteControlador.php');

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Cerrar sesión
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$controlador = new ComponenteControlador();
$tipos = $controlador->obtenerTipos();

// Si no hay tipo seleccionado, obtener todos los componentes
$tipoSeleccionado = isset($_GET['tipo']) && !empty($_GET['tipo']) ? $_GET['tipo'] : null;
$componentes = $tipoSeleccionado ? $controlador->obtenerComponentesPorTipo($tipoSeleccionado) : $controlador->obtenerComponentesPorTipo(null);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechWarriors</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/home.css">
</head>
<body>
<!-- Navbar -->
<div class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
    <div class="navbar-nav d-flex w-100 align-items-center">
        <div class="nav-item dropdown">
            <a class="navbar-brand mb-0 h1 dropdown-toggle" href="#" id="catalogDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Categoría
            </a>
            <div class="dropdown-menu" aria-labelledby="catalogDropdown">
                <a class="dropdown-item" href="home.php">Todos</a>
                <?php foreach ($tipos as $tipo): ?>
                    <a class="dropdown-item" href="home.php?tipo=<?php echo urlencode($tipo); ?>">
                        <?php echo htmlspecialchars(ucfirst($tipo)); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="ml-auto d-flex align-items-center">
            <span class="navbar-text text-white mr-3">
                Hola, <?php echo htmlspecialchars($_SESSION['username'] ?? ''); ?>
            </span>

            <!-- Mostrar carrito con redirección al carrito -->
            <a href="carrito.php" class="btn btn-outline-light ml-3">
                Carrito (<?php echo count($_SESSION['cart']); ?>) - $<?php echo number_format(array_sum(array_map(function($item) {
                    return $item['precio'] * $item['quantity'];
                }, $_SESSION['cart'])), 2); ?>
            </a>
            
            <!-- Botón de "Insertar Componente" solo para administradores -->
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <button onclick="location.href='cargar_componente.php'" class="btn btn-warning ml-2">Insertar Componente</button>
            <?php endif; ?>

            <!-- Botón de Menú con opción para cerrar sesión -->
            <div class="dropdown ml-2">
                <button class="btn btn-outline-light dropdown-toggle" type="button" id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Menú
                </button>
                <div class="dropdown-menu" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="?logout=true">Cerrar sesión</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Contenido principal -->
<div class="container text-center mt-5">
    <h1>TechWarriors</h1>
    <h3><?php echo $tipoSeleccionado ? 'Categoría: ' . htmlspecialchars(ucfirst($tipoSeleccionado)) : 'Todos los Componentes'; ?></h3>
    <section id="component-list" class="d-flex flex-wrap justify-content-center">
        <?php if (!empty($componentes)): ?>
            <?php foreach ($componentes as $componente): ?>
                <div class="card m-3" style="width: 18rem;">
                    <a href="componente.php?id=<?php echo $componente['id']; ?>">
                        <img src="img/<?php echo htmlspecialchars($componente['imagen']); ?>" class="card-img-top" alt="Imagen de <?php echo htmlspecialchars($componente['nombre']); ?>">
                    </a>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($componente['nombre']); ?></h5>
                        <p class="card-text"><strong>Precio: </strong>$<?php echo number_format($componente['precio'], 2); ?> MXN</p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No hay componentes disponibles en esta categoría.</p>
        <?php endif; ?>
    </section>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>