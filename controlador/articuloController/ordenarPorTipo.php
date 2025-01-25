<?php

require_once __DIR__ . '../../../modelo/articulo/ordenacionAnimales.php';

function obtenerAnimalesConOrden($start, $articulosPorPagina, $orden, $usuario_id = null, $articulosCopiados = null) {
    
    switch ($orden) {
        case 'nombre_asc':
            $columnaOrden = 'nombre_comun';
            $direccionOrden = 'ASC';
            break;
        case 'nombre_desc':
            $columnaOrden = 'nombre_comun';
            $direccionOrden = 'DESC';
            break;
        case 'tipo_mamifero':
            $columnaOrden = 'es_mamifero';
            $direccionOrden = 'DESC'; 
            break;
        case 'tipo_oviparo':
            $columnaOrden = 'es_mamifero';
            $direccionOrden = 'ASC'; 
            break;
        default:
            $columnaOrden = 'nombre_comun';
            $direccionOrden = 'ASC';
    }

    if ($articulosCopiados){
        // var_dump("aqui entra");
        // exit();
        return obtenerAnimalesCopiados($start, $articulosPorPagina, $columnaOrden, $direccionOrden, $usuario_id);

    }
 
    if ($usuario_id!=null){
        return obtenerAnimalesPorID($start, $articulosPorPagina, $columnaOrden, $direccionOrden, $usuario_id);
    }else return obtenerTodosAnimales($start, $articulosPorPagina, $columnaOrden, $direccionOrden);
   
}
?>