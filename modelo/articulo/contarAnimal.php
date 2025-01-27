<?php
// Función para contar todos los artículos o los del usuario
function contarArticulos($usuario_id = null)
{
    try {
        $pdo = connectarBD();

        if ($usuario_id) {
            $sql = "SELECT COUNT(*) FROM animales WHERE usuario_id = :usuario_id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
        } else {
            $sql = "SELECT COUNT(*) FROM animales";
            $stmt = $pdo->prepare($sql);
        }

        // Ejecutar consulta
        $stmt->execute();

        // Obtener el número de artículos
        $count = $stmt->fetchColumn();

        return $count;
    } catch (PDOException $e) {
        error_log("Error en la consulta: " . $e->getMessage());
        return false; // Devuelve false en caso de error
    }
}

// Función para contar los artículos copiados por el usuario
function contarAnimalesCopiados($usuario_id)
{
    try {
        $pdo = connectarBD();

        $sql = "SELECT COUNT(*) FROM animales_copia WHERE usuario_id = :usuario_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);

        // Ejecutar consulta
        $stmt->execute();

        // Obtener el número de artículos copiados
        $count = $stmt->fetchColumn();

        return $count;
    } catch (PDOException $e) {
        error_log("Error en la consulta: " . $e->getMessage());
        return false; // Devuelve false en caso de error
    }
}

