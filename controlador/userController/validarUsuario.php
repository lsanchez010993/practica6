<?php
// Validar si el usuario está duplicado
function comprobarUsuarioRepe($usuario)
{
    require_once "../../modelo/user/comprobarUsuario.php";
    if (usuarioRepetido($usuario)) {
        include_once '../../controlador/errores/errores.php';
        return [ErroresInicioSesion::ERROR_USUARIO_REPETIDO];
    } else {

        return false;
    }
}
function comprobarCorreoRepe($email)
{
    require_once "../../modelo/user/comprobarCorreo.php";
    if (correoRepetido($email)) {
        include_once '../../controlador/errores/errores.php';
        return [ErroresInicioSesion::ERROR_EMAIL_REPETIDO];
    } else {

        return false;
    }
}

function validarDatosNewUser($nombre_usuario, $email, $password, $confirm_password)
{
    $errores = [];


    // Validación de si el usuario está duplicado
    require_once "../../controlador/userController/validarUsuario.php";
    require_once "../../controlador/userController/validarPassword.php";
    $userDuplicado = comprobarUsuarioRepe($nombre_usuario);
    $correoDuplicado = comprobarCorreoRepe($email);
    $passCorrecto = comprobarPassword($password, $confirm_password);
    // Si hay errores, se acumulan en el array $errores
    if ($userDuplicado !== false) {
        $errores = array_merge($errores, $userDuplicado);
        return $errores;
    }
    if ($correoDuplicado !== false) {
        $errores = array_merge($errores, $correoDuplicado);
        return $errores;
    }
 
    if ($passCorrecto !== true) {

        $errores = array_merge($errores, $passCorrecto);
    }


    return $errores;
}
function registrarUsuarioController($errores, $nombre_usuario, $email, $password)
{

    if (empty($errores)) {
        require_once '../../modelo/user/registrarUsuario.php';
        include_once '../../controlador/errores/errores.php';
        if (registrarUsuario($nombre_usuario, $email, $password)) {
            return Mensajes::MENSAJE_EXITO_CREAR_USUARIO;
        }
    }
}
