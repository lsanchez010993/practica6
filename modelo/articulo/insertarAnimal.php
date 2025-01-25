<?php 

function actualizarAnimal($id, $nombre_comun, $nombre_cientifico, $descripcion, $rutaImagen, $es_mamifero)
{
    try {
        require_once __DIR__ . '/../conexion.php';
        $pdo = connectarBD();

        // Consulta de actualización con todos los campos relevantes
        $sql = "UPDATE animales 
                SET nombre_comun = :nombre_comun, 
                    nombre_cientifico = :nombre_cientifico, 
                    descripcion = :descripcion, 
                    ruta_imagen = :ruta_imagen, 
                    es_mamifero = :es_mamifero 
                WHERE id = :id";
                    
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nombre_comun', $nombre_comun, PDO::PARAM_STR);
        $stmt->bindParam(':nombre_cientifico', $nombre_cientifico, PDO::PARAM_STR);
        $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
        $stmt->bindParam(':ruta_imagen', $rutaImagen, PDO::PARAM_STR);
        $stmt->bindParam(':es_mamifero', $es_mamifero, PDO::PARAM_INT); 
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        $stmt->execute(); // Ejecutar la consulta

        // Verificar si se actualizó algún registro
        if ($stmt->rowCount() > 0) {
            return true; // Se actualizó correctamente
        } else {
            return false; // No se actualizó ningún registro (puede ser que no haya cambios)
        }
    } catch (PDOException $e) {
        error_log("Error al actualizar datos del animal: " . $e->getMessage());
        return false; // Devuelve false en caso de error
    }
}

function insertarAnimal($nombre_comun, $nombre_cientifico, $descripcion, $rutaImagen, $usuario_id, $es_mamifero)
{
    try {
        require_once __DIR__ . '/../conexion.php';
        $pdo = connectarBD();

        // Preparar la consulta SQL para insertar un nuevo registro en la tabla animales
        $sql = "INSERT INTO animales (nombre_comun, nombre_cientifico, descripcion, ruta_imagen, usuario_id, es_mamifero) 
                VALUES (:nombre_comun, :nombre_cientifico, :descripcion, :ruta_imagen, :usuario_id, :es_mamifero)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nombre_comun', $nombre_comun, PDO::PARAM_STR);
        $stmt->bindParam(':nombre_cientifico', $nombre_cientifico, PDO::PARAM_STR);
        $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
        $stmt->bindParam(':ruta_imagen', $rutaImagen, PDO::PARAM_STR);
        $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
        $stmt->bindParam(':es_mamifero', $es_mamifero, PDO::PARAM_INT); // Cambiado a PARAM_INT

        return $stmt->execute();
    } catch (PDOException $e) {
        error_log("Error al insertar un nuevo animal: " . $e->getMessage());
        return false;
    }
}
function insertarCopiaAnimal_QR($nombre_comun, $nombre_cientifico, $descripcion, $rutaImagen,  $es_mamifero)
{
    try {
        require_once __DIR__ . '/../conexion.php';
        $pdo = connectarBD();
      

        // Preparar la consulta SQL para insertar un nuevo registro en la tabla animales
        $sql = "INSERT INTO animales_copia (nombre_comun, nombre_cientifico, descripcion, ruta_imagen, usuario_id, es_mamifero) 
                VALUES (:nombre_comun, :nombre_cientifico, :descripcion, :ruta_imagen, :usuario_id, :es_mamifero)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nombre_comun', $nombre_comun, PDO::PARAM_STR);
        $stmt->bindParam(':nombre_cientifico', $nombre_cientifico, PDO::PARAM_STR);
        $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
        $stmt->bindParam(':ruta_imagen', $rutaImagen, PDO::PARAM_STR);
        $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
        $stmt->bindParam(':es_mamifero', $es_mamifero, PDO::PARAM_INT); // Cambiado a PARAM_INT
       
        return $stmt->execute();
    } catch (PDOException $e) {
        error_log("Error al insertar un nuevo animal: " . $e->getMessage());
        return false;
    }
}