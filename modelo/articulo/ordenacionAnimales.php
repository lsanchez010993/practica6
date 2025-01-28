<?php
// modelo/animalModel.php
require_once __DIR__ . '../../conexion.php';

function obtenerAnimalesPorID($start, $articulosPorPagina, $columnaOrden, $direccionOrden, $usuario_id = null)
{
    try {
        $pdo = connectarBD();

        $sql = "SELECT * FROM animales WHERE usuario_id = :usuario_id ORDER BY $columnaOrden $direccionOrden LIMIT :start, :limit";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
        $stmt->bindParam(':start', $start, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $articulosPorPagina, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error al obtener animales: " . $e->getMessage());
        return [];
    }
}
function obtenerAnimalesCopiados($start, $articulosPorPagina, $columnaOrden, $direccionOrden, $usuario_id = null)
{
    try {
        $pdo = connectarBD();
        // var_dump($usuario_id);
        // exit();
        $sql = "SELECT * FROM animales_copia WHERE usuario_id = :usuario_id ORDER BY $columnaOrden $direccionOrden LIMIT :start, :limit";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
        $stmt->bindParam(':start', $start, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $articulosPorPagina, PDO::PARAM_INT);
        $stmt->execute();
      
    //   var_dump($stmt->fetchAll(PDO::FETCH_ASSOC));
    //   exit();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error al obtener animales: " . $e->getMessage());
        return [];
    }
}

function obtenerTodosAnimales($start, $articulosPorPagina, $columnaOrden, $direccionOrden)
{
    try {
        $pdo = connectarBD();

        // Preparar la consulta con el orden especificado

        $sql = "SELECT * FROM animales ORDER BY $columnaOrden $direccionOrden LIMIT :start, :limit";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':start', $start, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $articulosPorPagina, PDO::PARAM_INT);
        $stmt->execute();


        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error al obtener animales: " . $e->getMessage());
        return [];
    }
}
