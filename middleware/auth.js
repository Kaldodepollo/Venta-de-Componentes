const jwt = require("jsonwebtoken");

const verificarToken = (req, res, next) => {
    const authHeader = req.headers["authorization"];

    if (!authHeader) {
        return res.status(403).json({ mensaje: "Token requerido" });
    }

    const partes = authHeader.split(" ");
    if (partes.length !== 2 || partes[0] !== "Bearer") {
        return res.status(401).json({ mensaje: "Token malformado" });
    }

    const token = partes[1];

    jwt.verify(token, process.env.JWT_SECRET, (err, decoded) => {
        if (err) {
            return res.status(401).json({ mensaje: "Token inválido" });
        }

        req.usuario = decoded;
        next();
    });
};

module.exports = verificarToken;
