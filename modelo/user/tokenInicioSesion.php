<?php

if (isset($_SESSION['nombre_usuario'])){
    session_start();
}



function almacenarTokenEnBD($nombre_usuario, $token)
{


    $pdo = connectarBD();
   


    $sql = "UPDATE usuarios SET token = :token WHERE nombre_usuario = :nombre_usuario";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':token', $token);
    $stmt->bindParam(':nombre_usuario', $nombre_usuario);
    $stmt->execute();
   
}

function verificarTokenSesion()
{

    if (isset($_COOKIE['remember_me'])) {
        $token = $_COOKIE['remember_me'];

       
        $pdo = connectarBD();
        $stmt = $pdo->prepare("SELECT nombre_usuario FROM usuarios WHERE token = :token");
        $stmt->bindParam(':token', $token);
        $stmt->execute();

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
           

            $_SESSION['nombre_usuario'] = $usuario['nombre_usuario'];
            return true;
        } else {
           
            setcookie('remember_me', '', time() - 3600, "/"); // Eliminar la cookie
        }
    }
    return false;
}
function cerrarSesion()
{
    
    require_once '../../modelo/conexion.php';
    $nombre_usuario = $_SESSION['nombre_usuario'];


    $pdo = connectarBD();
    $stmt = $pdo->prepare("UPDATE usuarios SET token = NULL WHERE nombre_usuario = :nombre_usuario");
    $stmt->bindParam(':nombre_usuario', $nombre_usuario);
    $stmt->execute();
    
    // Eliminar la cookie y destruir la sesión
    setcookie('remember_me', '', time() - 3600, "/");
    session_unset();
    session_destroy();
}
