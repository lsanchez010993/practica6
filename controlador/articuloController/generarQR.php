<?php
// generar_qr.php

// 1. Cargar el autoload de Composer (ajusta la ruta si es necesario)
require_once __DIR__ . '/../../vendor/autoload.php';

use chillerlan\QRCode\QRCode;  // Librería chillerlan

// 2. Preparar cabecera JSON (porque retornamos un objeto JSON, no la imagen directamente)
header('Content-Type: application/json');

// 3. Leer el cuerpo de la petición (JSON) que llega vía fetch/AJAX
$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    echo json_encode(['success' => false, 'message' => 'No data received']);
    exit;
}

// 4. Extraer parámetros
$id = $data['id'] ?? null;
$incluirNombreComun = $data['incluirNombreComun'] ?? false;
$incluirNombreCientifico = $data['incluirNombreCientifico'] ?? false;
$incluirDescripcion = $data['incluirDescripcion'] ?? false;
$incluirRutaImangen = $data['incluirRutaImangen'] ?? false;


// 5. Consultar la BD para obtener la información del animal (ajusta la ruta y conexión)
include_once __DIR__ . '../../../modelo/articulo/obtenerAnimalPor_Id.php';

$animal = obtenerAnimalPor_Id($id);



if (!$animal) {
    echo json_encode(['success' => false, 'message' => 'Animal no encontrado']);
    exit;
}


// 6. Construir el texto en función de los checkboxes marcados
$textoQR = URL_QR;



// 6. Construir la URL con los datos del animal
$baseURL = URL_QR . "/insertarAnimal_QR.php"; // página que insertará el animal
$queryParams = [];

// En este ejemplo, usaremos GET para cada campo marcado
if ($incluirNombreComun) {
    $queryParams['nombre_comun'] = $animal['nombre_comun'];
}
if ($incluirNombreCientifico) {
    $queryParams['nombre_cientifico'] = $animal['nombre_cientifico'];
}
if ($incluirDescripcion) {
    $queryParams['descripcion'] = $animal['descripcion'];
}

$queryParams['ruta_imagen'] = $animal['ruta_imagen'];


// Construimos la query
// -> http://localhost/practicas/practica6/insertarAnimal.php?nombre_comun=León&nombre_cientifico=Panthera+leo&descripcion=...
$textoQR = $baseURL . '?' . http_build_query($queryParams);


// Si por algún motivo el texto queda vacío, agrega un fallback:
if (!$textoQR) {
    $textoQR = "No se ha seleccionado ningún campo para mostrar.";
}

// 7. Generar el QR con chillerlan/php-qrcode
try {

    $qrRawData = (new QRCode)->render($textoQR);

    // Preparamos respuesta JSON
    $response = [
        'success' => true,
        'qr_url' => $qrRawData
    ];


    echo json_encode($response);
    exit;
} catch (Exception $e) {
    // Si hay algún error en la generación
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    exit;
}
