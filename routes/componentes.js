const express = require("express");
const router = express.Router();
const { connection } = require("../config/config.db");
const verificarToken = require("../middleware/auth"); 

// 1. Obtener todos los componentes (PROTEGIDO)
router.get("/componentes", verificarToken, (req, res) => {
    connection.query("SELECT * FROM componentes", (error, results) => {
        if (error) throw error;
        res.status(200).json(results);
    });
});

// 2. Obtener un componente por ID (PROTEGIDO)
router.get("/componentes/:id", verificarToken, (req, res) => {
    const { id } = req.params;
    connection.query("SELECT * FROM componentes WHERE id = ?", [id], (error, results) => {
        if (error) throw error;
        results.length > 0 ? res.json(results[0]) : res.status(404).json({ mensaje: "Componente no encontrado" });
    });
});

// 3. Agregar un nuevo componente (PROTEGIDO)
router.post("/componentes", verificarToken, (req, res) => {
    const { nombre, imagen, precio, descripcion, tipo } = req.body;
    const nuevoComponente = { nombre, imagen, precio, descripcion, tipo };
    connection.query("INSERT INTO componentes SET ?", nuevoComponente, (error, result) => {
        if (error) throw error;
        res.status(201).json({ mensaje: "Componente agregado", id: result.insertId });
    });
});

// 4. Actualizar un componente por ID (PROTEGIDO)
router.put("/componentes/:id", verificarToken, (req, res) => {
    const { id } = req.params;
    const { nombre, imagen, precio, descripcion, tipo } = req.body;
    connection.query("UPDATE componentes SET ? WHERE id = ?", [{ nombre, imagen, precio, descripcion, tipo }, id], (error, result) => {
        if (error) throw error;
        result.affectedRows > 0 ? res.json({ mensaje: "Componente actualizado" }) : res.status(404).json({ mensaje: "Componente no encontrado" });
    });
});

// 5. Eliminar un componente por ID (PROTEGIDO)
router.delete("/componentes/:id", verificarToken, (req, res) => {
    const { id } = req.params;
    connection.query("DELETE FROM componentes WHERE id = ?", [id], (error, result) => {
        if (error) throw error;
        result.affectedRows > 0 ? res.json({ mensaje: "Componente eliminado" }) : res.status(404).json({ mensaje: "Componente no encontrado" });
    });
});

// 6. Obtener componentes por tipo (PROTEGIDO)
router.get("/componentes/tipo/:tipo", verificarToken, (req, res) => {
    const { tipo } = req.params;
    connection.query("SELECT * FROM componentes WHERE tipo = ?", [tipo], (error, results) => {
        if (error) throw error;
        res.json(results);
    });
});

// 7. Obtener componentes dentro de un rango de precios (PROTEGIDO)
router.get("/componentes/precio/:min/:max", verificarToken, (req, res) => {
    const { min, max } = req.params;
    connection.query("SELECT * FROM componentes WHERE precio BETWEEN ? AND ?", [min, max], (error, results) => {
        if (error) throw error;
        res.json(results);
    });
});

// 8. Actualizar solo el precio de un componente (PROTEGIDO)
router.patch("/componentes/:id/precio", verificarToken, (req, res) => {
    const { id } = req.params;
    const { precio } = req.body;
    connection.query("UPDATE componentes SET precio = ? WHERE id = ?", [precio, id], (error, result) => {
        if (error) throw error;
        result.affectedRows > 0 ? res.json({ mensaje: "Precio actualizado" }) : res.status(404).json({ mensaje: "Componente no encontrado" });
    });
});

// 9. Buscar un componente por nombre (PROTEGIDO)
router.get("/componentes/buscar/:nombre", verificarToken, (req, res) => {
    const { nombre } = req.params;
    connection.query("SELECT * FROM componentes WHERE nombre LIKE ?", [`%${nombre}%`], (error, results) => {
        if (error) throw error;
        res.json(results);
    });
});

// 10. Eliminar todos los componentes (PROTEGIDO)
router.delete("/componentes", verificarToken, (req, res) => {
    connection.query("DELETE FROM componentes", (error, result) => {
        if (error) throw error;
        res.json({ mensaje: "Todos los componentes han sido eliminados" });
    });
});

module.exports = router;
