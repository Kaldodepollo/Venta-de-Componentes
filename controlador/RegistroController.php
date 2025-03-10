<?php
require_once '../modelo/UsuariosDB.php'; // Archivo de conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['username']);
    $correo = trim($_POST['email']);
    $numero = trim($_POST['phone']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']); // Captura el campo de confirmación
    $role = 'user'; // Rol predeterminado

    // Validar campos vacíos
    if (empty($usuario) || empty($correo) || empty($numero) || empty($password) || empty($confirm_password)) {
        echo "Todos los campos son obligatorios.";
        exit;
    }

    // Validar si las contraseñas coinciden
    if ($password !== $confirm_password) {
        echo "Las contraseñas no coinciden.";
        exit;
    }

    // Conexión a la base de datos
    $db = new UsuariosDB();

    // Verificar si el usuario o correo ya existe
    $existeUsuario = $db->buscarUsuario($usuario, $correo);
    if ($existeUsuario) {
        echo "El usuario o correo ya está registrado.";
        exit;
    }

    // Registrar el nuevo usuario (sin hash de la contraseña)
    $resultado = $db->registrarUsuario($usuario, $password, $correo, $numero, $role);
    if ($resultado) {
        echo "Registro exitoso.";
        header('Location: ../vista/login.php'); // Redirige al login tras registro exitoso
        exit;
    } else {
        echo "Error al registrar el usuario.";
    }
}
?>
