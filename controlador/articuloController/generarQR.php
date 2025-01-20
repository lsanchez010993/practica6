<?php
require_once __DIR__ . '../../../modelo/articulo/obtenerAnimalPor_Id.php';
require_once __DIR__ . '../../../modelo/articulo/generarQR.php';

function listarAnimalesController($id = null) {

    $animales = obtenerAnimalPor_Id($id);
    // var_dump($animales);
    return $animales;
}

function obtenerQRController($id) {
    $url = 'http://localhost/practicas/practica6/vista/animal/mostrarQR.php?id=' . $id;
    return generarQR($url);
}
