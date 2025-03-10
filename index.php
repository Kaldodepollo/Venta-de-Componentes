<?php
session_start();

// Si el carrito no está inicializado, lo inicializamos
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}


//require_once('./controlador/LoginController.php');
//echo "Archivo encontrado correctamente.";


// Incluir controladores necesarios
require_once('./controlador/LoginController.php');


// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['username'])) {
    header("Location: vista/login.php");
    exit();
}

// Obtener el controlador y la acción desde la URL, o establecer valores predeterminados
$controlador = $_GET['controlador'] ?? 'home';
$accion = $_GET['accion'] ?? 'index';

// Enrutamiento principal
switch ($controlador) {
    case 'usuario':
        $usuarioControlador = new UsuarioControlador();
        if ($accion == 'iniciarSesion') {
            $usuarioControlador->iniciarSesion();
        } elseif ($accion == 'registrarse') {
            $usuarioControlador->registrarse();
        }
        break;

    // Caso por defecto para el controlador 'home'
    default:
        header("Location: vista/home.php");
        exit();
}
?>
