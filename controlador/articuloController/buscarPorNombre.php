<?php

require_once __DIR__ . '../../../modelo/articulo/obtenerAnimalPor_Id.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_GET['nombre_comun']) && !empty($_GET['nombre_comun'])) {
    $nombre_comun = $_GET['nombre_comun'];

    if (isset($_SESSION['usuario_id'])) {
        $resultadosBusqueda = obtenerAnimalPorNombre_y_User($nombre_comun, $_SESSION['usuario_id']);
    } else {
        $resultadosBusqueda = obtenerAnimalPorNombre($nombre_comun);
    }
}


include_once __DIR__ . '../../../vista/animal/vistaAnimales.php';
?>
