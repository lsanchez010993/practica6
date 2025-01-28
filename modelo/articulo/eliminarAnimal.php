<?php

session_start(); // Asegúrate de iniciar la sesión al principio del archivo
$id = $_GET['id'];
if (isset($_GET['animalesCopiados'])) {
    
    eliminarArticuloCopia($id);

}else{
    eliminarArticulo($id);
}
   

    


function eliminarArticulo($id)
{
    try {
        // Asegúrate de que session_start() se ha llamado antes
        if (isset($_SESSION['administrar'])) {
            $rutaRedireccion = '../../index.php?administrar=true';
        } else {
            $rutaRedireccion = '../../index.php';
        }
        
        require_once __DIR__ . '/../conexion.php';

        $pdo = connectarBD();
        $sql = "DELETE FROM animales WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // Si el artículo se elimina correctamente, redirige a index
        header("Location: $rutaRedireccion");
        exit();
    } catch (PDOException $e) {
        error_log("Error al eliminar el artículo: " . $e->getMessage());
        return false; // Devuelve false en caso de error
    }
}
function eliminarArticuloCopia($id)
{
    try {
        // Asegúrate de que session_start() se ha llamado antes
        
            $rutaRedireccion = '../../index.php?animalesCopiados=true';
        
        
        require_once __DIR__ . '/../conexion.php';

        $pdo = connectarBD();
        $sql = "DELETE FROM animales_copia WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // Si el artículo se elimina correctamente, redirige a index
        header("Location: $rutaRedireccion");
        exit();
    } catch (PDOException $e) {
        error_log("Error al eliminar el artículo: " . $e->getMessage());
        return false; // Devuelve false en caso de error
    }
}
