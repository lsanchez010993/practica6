<!-- para dondominio -->
<?php
// define("DB_HOST", "bbdd.luissanchez.cat");
// define("DB_NAME", "ddb237135");
// define("DB_DSN", sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4', DB_HOST, DB_NAME));
// define("DB_USER", "ddb237135");
// define("DB_PASSWORD", "}.nS2g:34un,Wc");  // Reemplaza con tu contraseña
// define("DB_ERROR_MSG", "No es pot establir connexió amb la base de dades");
?>
<!-- phpmyadmin (local) -->
<?php
define("DB_HOST", "localhost"); // 'localhost' o la IP local
define("DB_NAME", "pt05_luis_sanchez"); // Cambia si usas otra base de datos
define("DB_DSN", sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4', DB_HOST, DB_NAME));
define("DB_USER", "root"); // Usuario local típico de MySQL
define("DB_PASSWORD", ""); // Deja vacío si no configuraste contraseña
define("DB_ERROR_MSG", "No es pot establir connexió amb la base de dades");
?>
