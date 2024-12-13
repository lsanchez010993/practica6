<?php
function verificarPasswordCorrecto_Controller($nombre_usuario, $password){
    require_once '../../modelo/user/actualizarPassword.php';
    return verificarPassCorrecto($nombre_usuario, $password);
}

function actualizarPassword_Controller($nombre_usuario, $nuevo_password){
    require_once '../../modelo/user/actualizarPassword.php';
    return actualizarPassword($nombre_usuario, $nuevo_password);
}



?>


