<?php
require_once __DIR__ . '/../../modelo/articulo/obtenerAnimalPor_Id.php';
require_once __DIR__ . '/../../modelo/articulo/obtenerNombreUsuario.php';
require_once __DIR__ . '../../../vendor/autoload.php';


use chillerlan\QRCode\QRCode;



function listarArticulosController($animales = null, $show_edit)
{



    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $animalesAPI = isset($_GET['animalesAPI'])
        ? filter_var($_GET['animalesAPI'], FILTER_VALIDATE_BOOLEAN)
        : false;

    // Asignar los datos filtrados a $animales y liberar la memoria de la versión original
    if ($animalesAPI) {
        
        $animalesFiltrados = [];

        foreach ($animales as $animal) {
            $animalesFiltrados[] = [
                'name' => $animal['name'] ?? 'No disponible',
                'scientific_name' => $animal['scientific_name'] ?? 'No disponible',
                'image_link' => $animal['image_link'] ?? 'Sin imagen'
            ];
        }


        $animales = null;
        $animales = $animalesFiltrados;
    }

    $nombre_usuario = isset($_SESSION['nombre_usuario']) ? $_SESSION['nombre_usuario'] : null;

    $animalesCopiados = isset($_GET['animalesCopiados'])
        ? filter_var($_GET['animalesCopiados'], FILTER_VALIDATE_BOOLEAN)
        : false;

    $esAdmin = (isset($_SESSION['administrar']) && $nombre_usuario === 'admin');
    $prefijoRutaImagen = '';

    foreach ($animales as $i => $animal) {

        if ($esAdmin) {
            $nombreUsuario = obtenerNombreUsuarioPorAnimal($animal['usuario_id']);
            $animales[$i]['nombreUsuario'] = $nombreUsuario;
        }


        if (!$animalesAPI) {
            // generar la URL para el QR
            $qrURL  = URL_QR . 'vistaQR.php/?id=' . $animal['id'];
            $qr = (new QRCode)->render($qrURL);
            $animales[$i]['qr'] = $qr;
        } else {


            $datosAnimal = [

                'name' => $animal['name'] ?? 'No disponible',

                'image_link' => $animal['image_link'] ?? 'Sin imagen'


            ];


            $jsonDatosAnimal = urlencode(json_encode($datosAnimal));


            $qrURL = URL_QR . "insertarAnimalAPI_QR.php?data=$jsonDatosAnimal";


            $qr = (new QRCode)->render($qrURL);

            // Guardar el QR en el array del animal
            $animales[$i]['qrAPI'] = $qr;
        }
    }
    // var_dump($animales);
    // exit();

    $datos = [
        'animales'          => $animales,
        'show_edit'            => $show_edit,
        'esAdmin'           => $esAdmin,
        'prefijoRutaImagen' => $prefijoRutaImagen,
        'animalesCopiados' => $animalesCopiados
    ];


    require __DIR__ . '/../../vista/animal/mostrarAnimalesVista.php';
}
