<?php

function comprobarPassword($password, $password2 = null)
{
    include_once '../../controlador/errores/errores.php';
    // Array para acumular los errores
    $errores = [];

    // Comprobar si las contraseñas coinciden
    if ($password2 !== null && $password !== $password2) {
        $errores[] = ErroresPassword::CONTRASEÑAS_NO_COINCIDEN;
        return $errores;
    }

    // Comprobar si la contraseña está definida y no está vacía
    if (!isset($password) || empty($password)) {
        $errores[] = ErroresPassword::CONTRASEÑA_VACIA;
        return $errores;
    }


    if (strlen($password) < 8) {
        $errores[] = ErroresPassword::CONTRASEÑA_CORTA;
    }


    if (!preg_match('/[0-9]/', $password)) {
        $errores[] = ErroresPassword::CONTRASEÑA_SIN_NUMERO;
    }


    if (!preg_match('/[a-z]/', $password)) {
        $errores[] = ErroresPassword::CONTRASEÑA_SIN_MINUSCULA;
    }


    if (!preg_match('/[A-Z]/', $password)) {
        $errores[] = ErroresPassword::CONTRASEÑA_SIN_MAYUSCULA;
    }


    if (!empty($errores)) {
        return $errores;
    }

    return true;
}

function verificarPassword_BD($usuario, $password, $nombre_usuario)
{
    // Verificar la contraseña
    if ($usuario && password_verify($password, $usuario['password'])) {

     
        require_once 'verificarSesion.php';
        inicioSesion();

        // Iniciar la sesión
        session_start();
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['nombre_usuario'] = $nombre_usuario;
        $_SESSION['login_time'] = time();

        return true;
    } else {
        return false;
    }
    
}
?>

