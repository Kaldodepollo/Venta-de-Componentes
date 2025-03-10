<?php
require_once(__DIR__ . '/../modelo/ComponentesDB.php');

class ComponenteControlador {
    // Método para insertar un componente
    public function insertarComponente($data, $file) {
        $nombre = $data['nombre'];
        $precio = $data['precio'];
        $descripcion = $data['descripcion'];
        $tipo = $data['tipo'];

        // Manejo de la imagen
        if (isset($file['imagen']) && $file['imagen']['error'] === UPLOAD_ERR_OK) {
            $imagenTmp = $file['imagen']['tmp_name'];
            $imagenNombre = basename($file['imagen']['name']);
            $rutaDestino = __DIR__ . '/../vista/img/' . $imagenNombre;

            if (move_uploaded_file($imagenTmp, $rutaDestino)) {
                $imagen = $imagenNombre;
            } else {
                die("Error al subir la imagen.");
            }
        } else {
            die("Imagen no válida.");
        }

        $db = new ComponentesDB();
        $conn = $db->getConnection();

        $query = "INSERT INTO componentes (nombre, imagen, precio, descripcion, tipo) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssdss", $nombre, $imagen, $precio, $descripcion, $tipo);

        if ($stmt->execute()) {
            header("Location: ../vista/home.php?status=success");
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }

    // Método para obtener todos los tipos de componentes
    public function obtenerTipos() {
        $db = new ComponentesDB();
        $conn = $db->getConnection();

        $query = "SELECT DISTINCT tipo FROM componentes";
        $result = $conn->query($query);

        $tipos = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $tipos[] = $row['tipo'];
            }
        }

        $conn->close();
        return $tipos;
    }

    // Método para obtener componentes según el tipo
    public function obtenerComponentesPorTipo($tipo = null) {
        $db = new ComponentesDB();
        $conn = $db->getConnection();

        if ($tipo) {
            $query = "SELECT * FROM componentes WHERE tipo = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $tipo);
            $stmt->execute();
            $result = $stmt->get_result();
        } else {
            $query = "SELECT * FROM componentes"; // Recuperar todos los componentes
            $result = $conn->query($query);
        }

        $componentes = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $componentes[] = $row;
            }
        }

        if (isset($stmt)) {
            $stmt->close();
        }
        $conn->close();
        return $componentes;
    }
}
