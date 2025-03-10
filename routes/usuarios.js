const express = require("express");
const bcrypt = require("bcrypt");
const connection = require("../config/db");

const router = express.Router();

// Registrar un nuevo usuario
router.post("/usuarios", async (req, res) => {
    const { usuario, contraseña, role } = req.body;

    if (!usuario || !contraseña || !role) {
        return res.status(400).json({ mensaje: "Todos los campos son obligatorios" });
    }

    try {
        const hash = await bcrypt.hash(contraseña, 10);
        const nuevoUsuario = { usuario, password: hash, role };

        connection.query("INSERT INTO usuarios SET ?", nuevoUsuario, (error, result) => {
            if (error) {
                console.error("Error en la BD:", error);
                return res.status(500).json({ mensaje: "Error al registrar usuario" });
            }
            res.status(201).json({ mensaje: "Usuario registrado", id: result.insertId });
        });

    } catch (error) {
        res.status(500).json({ mensaje: "Error al cifrar la contraseña" });
    }
});

module.exports = router;
