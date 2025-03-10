<?php
class UsuariosDB {
    private $host = "localhost";
    private $db_name = "componentesonline"; // Nombre de la base de datos
    private $username = "root"; // Cambia si usas otro usuario en WAMP Server
    private $password = ""; // Cambia si tienes una contraseña configurada
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_name);
        } catch (Exception $exception) {
            echo "Error de conexión: " . $exception->getMessage();
        }
        return $this->conn;
    }

    // Función para buscar un usuario por nombre o correo (para evitar duplicados)
    public function buscarUsuario($usuario, $correo) {
        $this->getConnection();
        $query = $this->conn->prepare("SELECT * FROM usuarios WHERE usuario = ? OR correo = ?");
        $query->bind_param("ss", $usuario, $correo);
        $query->execute();
        $result = $query->get_result();
        return $result->num_rows > 0; // Devuelve true si existe
    }

    // Función para registrar un nuevo usuario
    public function registrarUsuario($usuario, $password, $correo, $numero, $role = 'user') {
        $this->getConnection();
        $query = $this->conn->prepare("INSERT INTO usuarios (usuario, password, correo, numero, role) VALUES (?, ?, ?, ?, ?)");
        $query->bind_param("sssss", $usuario, $password, $correo, $numero, $role);
        return $query->execute(); // Devuelve true si el registro fue exitoso
    }

    // Nueva función: Buscar un usuario por correo, teléfono o usuario
    public function buscarUsuarioPorOpciones($correo, $numero, $usuario) {
        $this->getConnection();
        $query = $this->conn->prepare("SELECT * FROM usuarios WHERE correo = ? OR numero = ? OR usuario = ?");
        $query->bind_param("sss", $correo, $numero, $usuario);
        $query->execute();
        $result = $query->get_result();
        return $result->fetch_assoc(); // Devuelve un array asociativo del usuario encontrado o false si no existe
    }

    // Función para buscar un usuario por correo y número (recuperar contraseña)
    public function buscarUsuarioPorCorreoYNumero($correo, $numero) {
        $this->getConnection();
        $query = $this->conn->prepare("SELECT * FROM usuarios WHERE correo = ? AND numero = ?");
        $query->bind_param("ss", $correo, $numero);
        $query->execute();
        $result = $query->get_result();
        return $result->fetch_assoc(); // Devuelve un array asociativo del usuario encontrado
    }

    // Función para validar intentos fallidos de inicio de sesión
    public function registrarIntentoFallido($usuario) {
        $this->getConnection();
        $query = $this->conn->prepare("UPDATE usuarios SET intentos = intentos + 1 WHERE usuario = ?");
        $query->bind_param("s", $usuario);
        $query->execute();

        // Verificar si se excedieron los intentos permitidos (3 por ejemplo)
        $query = $this->conn->prepare("SELECT intentos FROM usuarios WHERE usuario = ?");
        $query->bind_param("s", $usuario);
        $query->execute();
        $result = $query->get_result();
        $usuarioData = $result->fetch_assoc();

        if ($usuarioData && $usuarioData['intentos'] >= 3) {
            $this->bloquearUsuario($usuario); // Bloquear al usuario
            return true; // Usuario bloqueado
        }
        return false; // Intento fallido, pero no bloqueado
    }

    // Función para bloquear al usuario después de varios intentos fallidos
    private function bloquearUsuario($usuario) {
        $this->getConnection();
        $query = $this->conn->prepare("UPDATE usuarios SET bloqueado = 1 WHERE usuario = ?");
        $query->bind_param("s", $usuario);
        $query->execute();
    }

    // Función para desbloquear al usuario manualmente (si es necesario)
    public function desbloquearUsuario($usuario) {
        $this->getConnection();
        $query = $this->conn->prepare("UPDATE usuarios SET intentos = 0, bloqueado = 0 WHERE usuario = ?");
        $query->bind_param("s", $usuario);
        return $query->execute(); // Devuelve true si el desbloqueo fue exitoso
    }

    // Función para verificar si un usuario está bloqueado
    public function usuarioBloqueado($usuario) {
        $this->getConnection();
        $query = $this->conn->prepare("SELECT bloqueado FROM usuarios WHERE usuario = ?");
        $query->bind_param("s", $usuario);
        $query->execute();
        $result = $query->get_result();
        $usuarioData = $result->fetch_assoc();
        return $usuarioData && $usuarioData['bloqueado'] == 1; // Devuelve true si está bloqueado
    }
}

class Database {
    private static $instance = null;
    private $connection;

    private function __construct() {
        try {
            $this->connection = new PDO("mysql:host=localhost;dbname=tu_base_de_datos", "usuario", "contraseña");
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->exec("SET NAMES 'utf8'");
        } catch (PDOException $e) {
            die("Error en la conexión a la base de datos: " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->connection;
    }
}
?>
