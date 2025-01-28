
<?php
// define("DB_HOST", "bbdd.luissanchez.cat");
// define("DB_NAME", "ddb237135");
// define("DB_DSN", sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4', DB_HOST, DB_NAME));
// define("DB_USER", "ddb237135");
// define("DB_PASSWORD", "}.nS2g:34un,Wc");  // Reemplaza con tu contraseña
// define("DB_ERROR_MSG", "No es pot establir connexió amb la base de dades");
// define("CALLBACKURL","/controlador/userController/githubAuth.php");
// define("ID_GITHUB","Ov23liJDh5AJQjacuTfs");
// define("kEY_SECRET_GITHUB","737a0c072a32a00061c594e882ec9369d15566aa");
// define ("ENLACE_RECUPERACION_PASS", "http://luissanchez.cat/vista/usuaris/cambiarContrasenya.php?token=");
// define("URL_QR", "http://luissanchez.cat/vista/animal/");

?>


<?php
define("DB_HOST", "localhost"); // 'localhost' o la IP local
define("DB_NAME", "pt05_luis_sanchez"); // Cambia si usas otra base de datos
define("DB_DSN", sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4', DB_HOST, DB_NAME));
define("DB_USER", "root"); // Usuario local típico de MySQL
define("DB_PASSWORD", ""); // Deja vacío si no configuraste contraseña
define("DB_ERROR_MSG", "No es pot establir connexió amb la base de dades");
define("CALLBACKURL", "/practicas/practica6/controlador/userController/githubAuth.php");
define("ID_GITHUB", "Ov23licaFa22CeJ8F1Al");
define("kEY_SECRET_GITHUB", "fcf3d6db0516a032ab052a178c4343aa79e4a511");
define("ENLACE_RECUPERACION_PASS", "localhost/practicas/practica5/vista/usuaris/cambiarContrasenya.php?token=");
define("URL_QR", "http://localhost/practicas/practica6/vista/animal/");

?>