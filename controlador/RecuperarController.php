<?php
require_once '../modelo/UsuariosDB.php'; // Archivo de conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = trim($_POST['email']);
    $numero = trim($_POST['phone']);
    $nombre = trim($_POST['username']);

    // Validar que al menos uno de los campos esté lleno
    if (empty($correo) && empty($numero) && empty($nombre)) {
        $mensaje = "Debe completar al menos uno de los campos: correo, teléfono o usuario.";
        $tipo = "warning";
        include '../vista/recuperarcontraseña.php';
        exit;
    }

    $db = new UsuariosDB();
    $db->getConnection();

    // Buscar usuario por correo, teléfono o nombre de usuario
    $usuario = $db->buscarUsuarioPorOpciones($correo, $numero, $nombre);

    if ($usuario) {
        // Datos del usuario encontrados
        $mensaje = "Hola, " . htmlspecialchars($usuario['usuario']) . ". Tu contraseña es: <strong>" . htmlspecialchars($usuario['password']) . "</strong>";
        $tipo = "success";
    } else {
        // Usuario no encontrado
        $mensaje = "No se encontró ningún usuario con los datos proporcionados.";
        $tipo = "danger";
    }
    include '../vista/recuperarcontraseña.php';
}
?>
