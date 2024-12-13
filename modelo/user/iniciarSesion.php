<?php


function iniciarSesion($nombre_usuario)
{
    try {
        require_once '../../modelo/conexion.php';
        require_once "../../controlador/errores/errores.php";
        $errores = "";
        $nombre_usuario = $_POST['nombre_usuario'];
       
        $pdo = connectarBD();
        $sql = "SELECT id, password FROM usuarios WHERE nombre_usuario = :nombre_usuario";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nombre_usuario', $nombre_usuario);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        return $usuario;

    } catch (PDOException $e) {
             error_log("Error al iniciar sesión: " . $e->getMessage());
        $errores = [ErroresInicioSesion::ERROR_INICIO_SESION];
        require_once '../../vista/usuaris/inicioSesion.form.php';
        return $errores;
    }
}
?>
