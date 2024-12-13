
<?php

require_once __DIR__ . '../../../modelo/articulo/obtenerAnimalPor_Id.php';

// Iniciar la sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar si se ha proporcionado el parámetro 'nombre_comun'
if (isset($_GET['nombre_comun']) && !empty($_GET['nombre_comun'])) {
    $nombre_comun = $_GET['nombre_comun'];

    // Verificar si el usuario está logueado para buscar con usuario_id
    if (isset($_SESSION['usuario_id'])) {
        $resultadosBusqueda = obtenerAnimalPorNombre_y_User($nombre_comun, $_SESSION['usuario_id']);
    } else {
        $resultadosBusqueda = obtenerAnimalPorNombre($nombre_comun);
    }
}

// Incluir el archivo principal (verifica que la ruta sea correcta)
include __DIR__ . '../../../index.php';
?>
