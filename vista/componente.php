<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Manejo del cierre de sesión
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: login.php');
    exit();
}

// Verificar si el carrito existe, si no inicializarlo
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Si el formulario fue enviado, agregar el producto al carrito
if (isset($_POST['add_to_cart'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];

    // Verificar si el producto ya está en el carrito
    if (isset($_SESSION['cart'][$id])) {
        // Si ya está, aumentar la cantidad
        $_SESSION['cart'][$id]['quantity']++;
    } else {
        // Si no está en el carrito, agregarlo
        $_SESSION['cart'][$id] = [
            'nombre' => $nombre,
            'precio' => $precio,
            'quantity' => 1
        ];
    }

    // Redirigir a la misma página después de agregar al carrito
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
}

require_once('../modelo/ComponentesDB.php');

// Obtener el ID del componente desde la URL
$id = isset($_GET['id']) ? $_GET['id'] : null;

// Verificar si se ha proporcionado un ID válido
if ($id === null) {
    echo "No se encontró el componente.";
    exit();
}

// Clase para obtener la información del componente
class ComponenteController {
    public function getComponenteById($id) {
        $db = new ComponentesDB();
        $conn = $db->getConnection();

        $query = "SELECT * FROM componentes WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return null;
    }
}

// Instancia del controlador
$componenteController = new ComponenteController();
$componente = $componenteController->getComponenteById($id);

// Verificar si se encontró el componente
if ($componente === null) {
    echo "Componente no encontrado.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Componente</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/componente.css">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
    <a class="navbar-brand" href="home.php">TechWarriors</a>
    <div class="ml-auto">
        <span class="navbar-text text-white mr-3">
            Hola, <?php echo htmlspecialchars($_SESSION['username'] ?? 'Usuario'); ?>
        </span>

        <!-- Mostrar carrito -->
        <div class="dropdown d-inline">
            <button class="btn btn-outline-light dropdown-toggle" type="button" id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Carrito (<?php echo count($_SESSION['cart']); ?>) - $<?php echo number_format(array_sum(array_map(function($item) {
                    return $item['precio'] * $item['quantity'];
                }, $_SESSION['cart'])), 2); ?>
            </button>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                <?php if (empty($_SESSION['cart'])): ?>
                    <a class="dropdown-item" href="#">Tu carrito está vacío</a>
                <?php else: ?>
                    <a class="dropdown-item" href="carrito.php">Ver carrito</a>
                <?php endif; ?>
            </div>
        </div>

        <div class="dropdown d-inline">
            <button class="btn btn-outline-light dropdown-toggle" type="button" id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?php echo ($_SESSION['role'] ?? '') === 'admin' ? 'Admin' : 'Usuario'; ?>
            </button>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="?logout=true">Cerrar sesión</a>
            </div>
        </div>
    </div>
</nav>

<!-- Detalles del producto -->
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <img src="img/<?php echo htmlspecialchars($componente['imagen']); ?>" class="pizza-img" alt="Imagen de <?php echo htmlspecialchars($componente['nombre']); ?>">
                <div class="card-body">
                    <h5 class="heading"><?php echo htmlspecialchars($componente['nombre']); ?></h5>
                    <p class="card-text"><?php echo nl2br(htmlspecialchars($componente['descripcion'])); ?></p>
                    <p class="card-text"><strong>Precio: </strong><span class="text-highlight">$<?php echo number_format($componente['precio'], 2); ?> MXN</span></p>

                    <!-- Formulario para agregar al carrito -->
                    <form action="componente.php?id=<?php echo $componente['id']; ?>" method="POST">
                        <input type="hidden" name="id" value="<?php echo $componente['id']; ?>">
                        <input type="hidden" name="nombre" value="<?php echo $componente['nombre']; ?>">
                        <input type="hidden" name="precio" value="<?php echo $componente['precio']; ?>">
                        <button type="submit" name="add_to_cart" class="btn btn-success">Agregar al carrito</button>
                    </form>

                    <a href="home.php" class="btn btn-primary mt-3">Volver a la página de inicio</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
