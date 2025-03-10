require("dotenv").config();
const express = require("express");
const jwt = require("jsonwebtoken");
const bcrypt = require("bcrypt");
const db = require("../config/db");

const router = express.Router();

router.post("/login", (req, res) => {
    const { usuario, contraseña } = req.body;

    const query = "SELECT * FROM usuarios WHERE usuario = ?";
    db.query(query, [usuario], async (err, results) => {
        if (err) {
            console.error("❌ Error en la consulta:", err);
            return res.status(500).json({ mensaje: "Error en el servidor" });
        }

        if (results.length === 0) {
            return res.status(401).json({ mensaje: "Credenciales incorrectas" });
        }

        const usuarioDB = results[0];

        // Comparar contraseñas con bcrypt
        const match = await bcrypt.compare(contraseña, usuarioDB.password);
        if (!match) {
            return res.status(401).json({ mensaje: "Credenciales incorrectas" });
        }

        // Verificar que JWT_SECRET está definido
        if (!process.env.JWT_SECRET) {
            return res.status(500).json({ mensaje: "Error en la configuración del servidor" });
        }

        const token = jwt.sign(
            { id: usuarioDB.id, usuario: usuarioDB.usuario, role: usuarioDB.role },
            process.env.JWT_SECRET,
            { expiresIn: "1h" }
        );

        res.json({ token, usuario: usuarioDB.usuario, role: usuarioDB.role });
    });
});

module.exports = router;
