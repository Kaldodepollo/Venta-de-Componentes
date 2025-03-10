<?php
class UsuarioModelo {
    private $conn;
    private $table_name = 'usuarios';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function authenticate($username, $password) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE usuario = :username AND password = :password";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }
}
?>
