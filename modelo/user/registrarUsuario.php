<?php
function registrarUsuario($nombre_usuario, $email, $password)
{
    try {
       
        $pdo = connectarBD();

        
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

       
        $sql = "INSERT INTO usuarios (nombre_usuario, email, password) VALUES (:nombre_usuario, :email, :password)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nombre_usuario', $nombre_usuario);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        // Manejo de excepciones de PDO
        return "Error al registrar el usuario: " . $e->getMessage();
    }
}
?>
