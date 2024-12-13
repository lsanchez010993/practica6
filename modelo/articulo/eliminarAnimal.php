<?php

session_start(); // Asegúrate de iniciar la sesión al principio del archivo

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    eliminarArticulo($id);
} else {
    echo "No se ha proporcionado un ID válido para eliminar el artículo.";
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
