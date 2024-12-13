<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim(strtolower($_POST['email']));
}

function correoRepetido($email)
{
    try {
        require_once '../../modelo/conexion.php';

        $pdo = connectarBD();

       
        $sql = "SELECT COUNT(*) FROM usuarios WHERE LOWER(email) = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        return $count > 0;
    } catch (PDOException $e) {
       
        error_log("Error al verificar si el correo está repetido: " . $e->getMessage());
        return false; 
    }
}
function verificarCorreo($email){
    require_once '../../modelo/conexion.php';
    $pdo = connectarBD();

   
    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE LOWER(email) = :email");
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
