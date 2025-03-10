const mysql = require("mysql2");
require("dotenv").config(); 

const connection = mysql.createConnection({
    host: process.env.DBHOST,
    user: process.env.DBUSER,
    password: process.env.DBPASS,
    database: process.env.DBNAME
    
});

connection.connect((err) => {
    if (err) {
        console.error("❌ Error conectando a la base de datos:", err);
        return;
    }
    console.log("✅ Conectado a la base de datos MySQL");
});

module.exports = connection;
