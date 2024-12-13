<?php
 require_once __DIR__ . '/../configs.php';
function connectarBD() {
    try {
        // Usar constantes definidas en configs.php
        $conexion = new PDO(DB_DSN, DB_USER, DB_PASSWORD);
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       // echo "Conexión exitosa a la base de datos.";
        return $conexion; // Retorna la conexión para uso en otras funciones
    } catch (PDOException $e) {
        echo DB_ERROR_MSG . ": " . $e->getMessage();
        return null; // Retorna null si hay un error
    }
}

?>
