<?php
session_start();
require_once(__DIR__ . '/../modelo/UsuariosDB.php');

class LoginController {
    public function login($username, $password) {
        $db = new UsuariosDB(); // Usamos la clase UsuariosDB
        $conn = $db->getConnection();

        // Preparar la consulta para buscar el usuario
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE usuario = ? AND password = ?");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $_SESSION['username'] = $user['usuario'];
            $_SESSION['role'] = $user['role']; // Almacena el rol en la sesión
            header("Location: ../vista/home.php"); // Redirige a home.php si la autenticación es exitosa
            exit();
        } else {
            $_SESSION['error'] = "Usuario o contraseña incorrectos";
            header("Location: ../vista/login.php"); // Redirige de vuelta a login.php con un mensaje de error
            exit();
        }
    }
}

// Manejo del formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $controller = new LoginController();
    $controller->login($_POST['username'], $_POST['password']);
}
?>
