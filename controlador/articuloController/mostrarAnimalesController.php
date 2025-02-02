<?php
require_once __DIR__ . '/../../modelo/articulo/obtenerAnimalPor_Id.php';
require_once __DIR__ . '/../../modelo/articulo/obtenerNombreUsuario.php';
require_once __DIR__ . '../../../vendor/autoload.php';


use chillerlan\QRCode\QRCode;



function listarArticulosController($animales = null, $show_edit)
{
    // var_dump("Los gatos se ven aqui");

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $animalesAPI = isset($_GET['animalesAPI'])
        ? filter_var($_GET['animalesAPI'], FILTER_VALIDATE_BOOLEAN)
        : false;




    $nombre_usuario = isset($_SESSION['nombre_usuario']) ? $_SESSION['nombre_usuario'] : null;

    $animalesCopiados = isset($_GET['animalesCopiados'])
        ? filter_var($_GET['animalesCopiados'], FILTER_VALIDATE_BOOLEAN)
        : false;

    $esAdmin = (isset($_SESSION['administrar']) && $nombre_usuario === 'admin');
    $prefijoRutaImagen = 'vista/';

    foreach ($animales as $i => $animal) {

        if ($esAdmin) {
            $nombreUsuario = obtenerNombreUsuarioPorAnimal($animal['usuario_id']);
            $animales[$i]['nombreUsuario'] = $nombreUsuario;
        }


        if (!$animalesAPI) {
            // generar la URL para el QR
            $qrURL  = URL_QR . 'vistaQR.php/?id='.$animal['id'];
            $qr = (new QRCode)->render($qrURL);
            $animales[$i]['qr'] = $qr;
        }
    }


    $datos = [
        'animales'          => $animales,
        'show_edit'            => $show_edit,
        'esAdmin'           => $esAdmin,
        'prefijoRutaImagen' => $prefijoRutaImagen,
        'animalesCopiados' => $animalesCopiados
    ];


    require __DIR__ . '/../../vista/animal/mostrarAnimalesVista.php';
}
