<?php
//inicia una sesión si no está ya activa, luego verifica si el usuario ha iniciado sesión. 
//Si la sesión ha expirado, la destruye y redirige al usuario a una página de sesión expirada. 
//Si no ha expirado, actualiza el tiempo de inicio de sesión. Si no hay sesión de usuario, redirige al índice.
function verificarSesion()
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (isset($_SESSION['usuario_id'])) {
        if (time() - $_SESSION['login_time'] > 2400) {
            session_unset();
            session_destroy();
           
            header('Location: vista/usuaris/sesionExpirada.php');
            exit();
        } else {
            
            $_SESSION['login_time'] = time();
        }
    } else {
        header('Location: index.php');
        exit();
    }
}
function inicioSesion()
{
    ini_set('session.gc_maxlifetime', 2400);
    session_set_cookie_params(2400);
}
