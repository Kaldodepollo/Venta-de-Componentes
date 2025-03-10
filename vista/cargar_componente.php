<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertar Componente</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/home.css">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center">Insertar Nuevo Componente</h1>
    <form action="../controlador/ComponenteControlador.php" method="POST" enctype="multipart/form-data" class="mt-4">
        <div class="form-group">
            <label for="nombre">Nombre del Componente:</label>
            <input type="text" id="nombre" name="nombre" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="imagen">Imagen del Componente:</label>
            <input type="file" id="imagen" name="imagen" class="form-control-file" accept="image/*" required>
        </div>
        <div class="form-group">
            <label for="precio">Precio (MXN):</label>
            <input type="number" id="precio" name="precio" class="form-control" step="0.01" required>
        </div>
        <div class="form-group">
            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" class="form-control" rows="3" required></textarea>
        </div>
        <div class="form-group">
            <label for="tipo">Tipo de Componente:</label>
            <select id="tipo" name="tipo" class="form-control" required>
                <option value="procesador">Procesador</option>
                <option value="tarjeta_grafica">Tarjeta Gráfica</option>
                <option value="almacenamiento">Almacenamiento</option>
                <option value="ram">RAM</option>
                <option value="placa_base">Placa Base</option>
                <option value="fuente_alimentacion">Fuente de Alimentación</option>
                <option value="gabinete">Gabinete</option>
                <option value="periferico">Periférico</option>
            </select>
        </div>
        <button type="submit" name="action" value="insertar" class="btn btn-primary btn-block">Guardar Componente</button>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
