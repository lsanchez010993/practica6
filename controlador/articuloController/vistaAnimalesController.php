<?php
require_once __DIR__ . '../../articuloController/ordenarPorTipo.php';
require_once __DIR__ . '../../../modelo/conexion.php';
require_once __DIR__ . '../../../modelo/articulo/contarAnimal.php';
require_once __DIR__ . '../../../modelo/articulo/limit_animales_por_pagina.php';
function obtenerArticulosYTotal($params)
{



    $start = ($params['pagina'] - 1) * $params['articulosPorPagina'];

 
   


    if (!empty($params['is_admin']) && !empty($params['administrar'])) {
        // Admin en modo administrar: mostrar todos los artículos con opción de editar
        $totalArticulos = contarArticulos();
        $animales = obtenerAnimalesConOrden($start, $params['articulosPorPagina'], $params['orden']);
        $show_edit = true;
    } elseif (!empty($params['user_id']) && !$params['todosAnimales'] && !$params['animalesCopiados']) {

        // var_dump("mis fichas");

        // Usuario logueado (no admin o admin sin administrar): mostrar sus artículos
        $totalArticulos = contarArticulos($params['user_id']);
        $animales = obtenerAnimalesConOrden($start, $params['articulosPorPagina'], $params['orden'], $params['user_id']);
        $show_edit = true;
    } elseif (!empty($params['user_id']) && $params['todosAnimales'] && !$params['animalesCopiados']) {
        // var_dump("todos los animales");


        $totalArticulos = contarArticulos();
        $animales = obtenerAnimalesConOrden($start, $params['articulosPorPagina'], $params['orden']);
        $show_edit = false;
    } elseif (!empty($params['user_id']) && !$params['todosAnimales'] && $params['animalesCopiados']) {
        // echo "animales copiados";


        $totalArticulos = contarAnimalesCopiados($params['user_id']);
        // var_dump($totalArticulos);
        $animales = obtenerAnimalesConOrden($start, $params['articulosPorPagina'], $params['orden'], $params['user_id'], $params['animalesCopiados']);
        $show_edit = true;
    }else{
        //sesion no inciada
        $totalArticulos = contarArticulos($params['user_id'], $params['animalesCopiados']);
        var_dump($totalArticulos);
        $animales = obtenerAnimalesConOrden($start, $params['articulosPorPagina'], $params['orden']);
        $show_edit = false;
    }


    // Calcular el número total de páginas
    $totalPaginas = ceil($totalArticulos / $params['articulosPorPagina']);
    if ($params['pagina'] > $totalPaginas && $totalPaginas > 0) {
        $params['pagina'] = $totalPaginas;
    }

    return [
        'animales' => $animales,
        'totalArticulos' => $totalArticulos,
        'totalPaginas' => $totalPaginas,
        'show_edit' => $show_edit,
        'pagina' => $params['pagina']
    ];
}


function iniciarSesionYObtenerParametros()
{
    // Iniciar la sesión si no está iniciada
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Verificar si el usuario ha iniciado sesión y controlar la sesión
    if (isset($_SESSION['nombre_usuario'])) {
        $nombre_usuario = $_SESSION['nombre_usuario'];
        $user_id = $_SESSION['usuario_id'];
        $is_admin = ($nombre_usuario === 'admin');

        require_once __DIR__ . '../../../controlador/userController/verificarSesion.php';
        verificarSesion();
    } else {
        $nombre_usuario = null;
        $user_id = null;
        $is_admin = false;
    }

    // Verificar si el parámetro 'administrar' está activado
    $administrar = (isset($_GET['administrar']) && $_GET['administrar'] === 'true');

    // Obtener filtros
    $todosAnimales = isset($_GET['todosAnimales'])
        ? filter_var($_GET['todosAnimales'], FILTER_VALIDATE_BOOLEAN)
        : false;

    $animalesCopiados = isset($_GET['animalesCopiados'])
        ? filter_var($_GET['animalesCopiados'], FILTER_VALIDATE_BOOLEAN)
        : false;

    // Obtener el número de artículos por página (SIN usar cookies)
    if (isset($_GET['posts_per_page'])) {
        $articulosPorPagina = (int)$_GET['posts_per_page'];
    } else {
        $articulosPorPagina = 6; // Valor por defecto de 6
    }

    // Obtener la página actual (SIN usar cookies)
    if (isset($_GET['page'])) {
        $pagina = (int)$_GET['page'];
    } else {
        $pagina = 1;
    }

    if ($pagina < 1) {
        $pagina = 1;
    }

    // Obtener el criterio de ordenación
    $orden = isset($_GET['orden']) ? $_GET['orden'] : 'nombre_asc'; // Por defecto, ordenar por nombre asc

    return [
        'nombre_usuario'   => $nombre_usuario,
        'user_id'          => $user_id,
        'is_admin'         => $is_admin,
        'administrar'      => $administrar,
        'articulosPorPagina' => $articulosPorPagina,
        'pagina'           => $pagina,
        'orden'            => $orden,
        'todosAnimales'    => $todosAnimales,
        'animalesCopiados' => $animalesCopiados
    ];
}

function mostrarArticulos($articlesData, $administrar)
{
    require_once __DIR__ . '../../../vista/animal/Mostrar.php';
    $_SESSION['administrar'] = $administrar;
    // Mostrar los artículos
    if ($articlesData['show_edit']) {

        listarArticulos($articlesData['articles'], 'editar');
    } else {

        listarArticulos($articlesData['articles']);
    }
}
