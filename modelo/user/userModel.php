<?php
require_once __DIR__ . '../../../modelo/conexion.php';

// Guardar el token de recuperación
function guardarTokenRecuperacion($email, $token, $expiracion)
{
    try {
        $pdo = connectarBD();
        $sql = "UPDATE usuarios SET token_recuperacion = :token, expiracion_token = :expiracion WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':expiracion', $expiracion);
        $stmt->bindParam(':email', $email);
     
        return $stmt->execute();
    } catch (PDOException $e) {
        error_log("Error al guardar el token: " . $e->getMessage());
        return false;
    }
}

// Verificar el token
function verificarToken($token)
{
    try {
        $pdo = connectarBD();
        
        $sql = "SELECT id FROM usuarios WHERE token_recuperacion = :token AND expiracion_token > NOW()";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':token', $token);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error al verificar el token: " . $e->getMessage());
        return false;
    }
}

// Cambiar la contraseña
function cambiarContrasenya($usuario_id, $password)
{
    try {
        $pdo = connectarBD();
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $sql = "UPDATE usuarios SET password = :password, token_recuperacion = NULL, expiracion_token = NULL WHERE id = :usuario_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':usuario_id', $usuario_id);
        return $stmt->execute();
    } catch (PDOException $e) {
        error_log("Error al cambiar la contraseña: " . $e->getMessage());
        return false;
    }
}

// Obtener usuario por email
function obtenerUsuarioPorEmail($email)
{
    try {
        $pdo = connectarBD();
        $sql = "SELECT * FROM usuarios WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error al obtener el usuario: " . $e->getMessage());
        return false;
    }
}
