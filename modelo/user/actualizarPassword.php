<?php
function actualizarPassword($nombre_usuario, $nuevo_password)
{
    try {
        require_once '../../modelo/conexion.php';
        $pdo = connectarBD();
        $sql = "UPDATE usuarios SET password = :password WHERE nombre_usuario = :nombre_usuario";
        $stmt = $pdo->prepare($sql);
        $hashed_password = password_hash($nuevo_password, PASSWORD_DEFAULT);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':nombre_usuario', $nombre_usuario);
        return $stmt->execute();
    } catch (PDOException $e) {
        error_log("Error al actualizar el password: " . $e->getMessage());
        return false;
    }
}
function verificarPassCorrecto($nombre_usuario, $password)
{
    try {
        require_once '../../modelo/conexion.php';
        $pdo = connectarBD();
        $sql = "SELECT password FROM usuarios WHERE nombre_usuario = :nombre_usuario";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nombre_usuario', $nombre_usuario);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        // Verificar si el usuario existe y si la contraseña es correcta
        if ($usuario && password_verify($password, $usuario['password'])) {
            return true; // Contraseña correcta
        } else {
            return false; // Contraseña incorrecta
        }
    } catch (PDOException $e) {
        error_log("Error al verificar el password: " . $e->getMessage());
        return false; // Error general
    }
}
?>
