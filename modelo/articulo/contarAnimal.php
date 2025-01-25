<?php
function contarArticulos($usuario_id = null, $animalesCopiados = null)
{
    try {

        $pdo = connectarBD();


        if ($usuario_id) {
            if ($animalesCopiados) {
                // var_dump('entra aqui');
                // exit();
                $sql = "SELECT COUNT(*) FROM animales_copia WHERE usuario_id = :usuario_id";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
            } else {
                $sql = "SELECT COUNT(*) FROM animales WHERE usuario_id = :usuario_id";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
            }
        } else {
            // Si no se proporciona usuario_id, cuenta todos los artículos
            $sql = "SELECT COUNT(*) FROM animales";
            $stmt = $pdo->prepare($sql);
        }
        


        // Ejecutar consulta
        $stmt->execute();
        // var_dump($stmt->execute());
        // exit();
        // Obtener el número de artículos
        $count = $stmt->fetchColumn();

        return $count;
    } catch (PDOException $e) {

        error_log("Error en la consulta: " . $e->getMessage());
        return false; // Devuelve false en caso de error
    }
}
