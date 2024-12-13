<?php

function eliminarNombreSession($nombreVariable)
{
    session_start();
    if (isset($_SESSION[$nombreVariable])) {
        unset($_SESSION[$nombreVariable]);
    }
  

 
    header("Location: ../../index.php");
    exit();
}

// Verifica si se recibe un parámetro por GET y llama a la función
if (isset($_GET['variable'])) {
    ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

    eliminarNombreSession($_GET['variable']);
}
