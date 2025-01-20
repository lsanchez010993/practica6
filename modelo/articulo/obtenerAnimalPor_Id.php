<?php
function obtenerAnimalPor_Id($id) {
    try {
        require_once __DIR__ . '/../conexion.php';
        $pdo = connectarBD();
        $sql = "SELECT * FROM animales WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      
        error_log("Error al obtener el animal por ID: " . $e->getMessage());
        return false; 
    }
}
function obtenerAnimales() {
    try {
        require_once __DIR__ . '/../conexion.php';
        $pdo = connectarBD();
        $sql = "SELECT * FROM animales";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        // Obtener todas las filas como un array asociativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Loguear el error para fines de depuración
        error_log("Error al obtener los animales: " . $e->getMessage());
        return false; 
    }
}

function obtenerAnimalPorNombre($nombre_comun) {
    try {
        require_once __DIR__ . '/../conexion.php';
        $pdo = connectarBD();
        $sql = "SELECT * FROM animales WHERE nombre_comun LIKE :nombre_comun";
        $stmt = $pdo->prepare($sql);
        $nombre_comun = $nombre_comun . '%'; 
        $stmt->bindParam(':nombre_comun', $nombre_comun, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    } catch (PDOException $e) {
        error_log("Error al obtener los animales por nombre común: " . $e->getMessage());
        return false; 
    }
}
function obtenerAnimalPorNombre_y_User($nombre_comun, $usuario_id) {
    try {
        require_once __DIR__ . '/../conexion.php';
        $pdo = connectarBD();
        
                $sql = "SELECT * FROM animales WHERE nombre_comun LIKE :nombre_comun AND usuario_id = :usuario_id";
        
        $stmt = $pdo->prepare($sql);
        
        $nombre_comun = $nombre_comun . '%'; // Buscar por nombre con prefijo
        $stmt->bindParam(':nombre_comun', $nombre_comun, PDO::PARAM_STR);
        $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);

      
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    } catch (PDOException $e) {
        error_log("Error al obtener los animales por nombre común y usuario: " . $e->getMessage());
        return false; 
    }
}

?>
