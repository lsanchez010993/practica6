<?php

function limit_animales_por_pagina($start, $animalesPerPage, $usuario_id = null)
{
    try {
       
       
        require_once __DIR__ . '/../conexion.php';
        $pdo = connectarBD(); 
       
        if ($usuario_id !== null) {
            $sql = "SELECT * FROM animales WHERE usuario_id = :usuario_id LIMIT :start, :animalesPerPage";
            $stmt = $pdo->prepare($sql);
           
            $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
            $stmt->bindParam(':start', $start, PDO::PARAM_INT);
            $stmt->bindParam(':animalesPerPage', $animalesPerPage, PDO::PARAM_INT);
        } else {
            // Prepara la consulta sin usuario_id
            $sql = "SELECT * FROM animales LIMIT :start, :animalesPerPage";
            $stmt = $pdo->prepare($sql);
            
            $stmt->bindParam(':start', $start, PDO::PARAM_INT);
            $stmt->bindParam(':animalesPerPage', $animalesPerPage, PDO::PARAM_INT);
        }

        // Ejecuta la consulta y obtiene los resultados
        $stmt->execute();
        $animales = $stmt->fetchAll();
        
        return $animales;
    } catch (PDOException $e) {
        
        error_log("Error al obtener artículos con limitación de página: " . $e->getMessage());
        return false; // Devuelve false en caso de error
    }
}
?>
