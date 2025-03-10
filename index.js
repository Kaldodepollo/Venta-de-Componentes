require("dotenv").config();
const express = require("express");
const cors = require("cors");

const app = express();
app.use(express.json());
app.use(cors());

// Cargamos las rutas
app.use(require("./routes/login"));
app.use(require("./routes/componentes"));
app.use(require("./routes/usuarios")); 

const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
    console.log(`Servidor corriendo en el puerto ${PORT}`);
});

module.exports = app;
