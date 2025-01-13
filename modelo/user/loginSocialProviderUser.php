<?php
function loginSocialProviderUser($email, $displayName)
{
    require_once __DIR__ . '/../conexion.php';
    $pdo = connectarBD();

    // Verificar si el usuario ya existe
    $sql = "SELECT * FROM usuarios WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {
        // El usuario ya existe, iniciar sesión
        session_start();
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['nombre_usuario'] = $usuario['nombre_usuario'];
    } else {
        // Registrar nuevo usuario
        $sql = "INSERT INTO usuarios (nombre_usuario, email) VALUES (:nombre_usuario, :email)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nombre_usuario', $displayName, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        // Iniciar sesión para el nuevo usuario
        session_start();
        $_SESSION['usuario_id'] = $pdo->lastInsertId();
        $_SESSION['nombre_usuario'] = $displayName;
    }
}
