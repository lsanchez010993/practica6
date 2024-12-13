<?php
function obtenerNombreUsuarioPorAnimal($usuario_id) {
    try {
        require_once __DIR__ . '/../conexion.php';
        $pdo = connectarBD();

        // Consulta SQL para obtener el nombre del usuario a partir del usuario_id de animales
        $sql = "SELECT u.nombre_usuario 
                FROM animales a
                INNER JOIN usuarios u ON a.usuario_id = u.id
                WHERE a.usuario_id = :usuario_id";

        // Preparar la consulta
        $stmt = $pdo->prepare($sql);

        // Vincular el parámetro :usuario_id
        $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);

        // Ejecutar la consulta
        $stmt->execute();

        // Devolver el nombre del usuario
        return $stmt->fetch(PDO::FETCH_ASSOC)['nombre_usuario'] ?? null; // Retorna null si no hay resultado
    } catch (PDOException $e) {
        // Registrar el error en un archivo de log
        error_log("Error al obtener el nombre del usuario: " . $e->getMessage());
        return false;
    }
}
