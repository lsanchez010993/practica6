<?php
    require_once __DIR__ . '../../articuloController/ordenarPorTipo.php';
    require_once __DIR__ . '../../../modelo/conexion.php';
    require_once __DIR__ . '../../../modelo/articulo/contarAnimal.php';
    require_once __DIR__ . '../../../modelo/articulo/limit_animales_por_pagina.php';
function obtenerArticulosYTotal($params) {


    // Calcular desde qué artículo iniciar
    $start = ($params['pagina'] - 1) * $params['articulosPorPagina'];
   
    
    // Obtener el total de artículos y los artículos a mostrar según el contexto
    if ($params['is_admin'] && $params['administrar']) {
        // Admin en modo administrar: mostrar todos los artículos con opción de editar
        $totalArticulos = contarArticulos();
        $animales = obtenerAnimalesConOrden($start, $params['articulosPorPagina'], $params['orden']);
        $show_edit = true;
    } elseif ($params['user_id'] !== null) {
        // Usuario logueado (no admin o admin sin administrar): mostrar sus artículos
        $totalArticulos = contarArticulos($params['user_id']);
        $animales = obtenerAnimalesConOrden($start, $params['articulosPorPagina'], $params['orden'], $params['user_id']);
        $show_edit = true;
    } else {
        // Usuario no logueado: mostrar todos los artículos sin opción de editar
        $totalArticulos = contarArticulos();
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



function iniciarSesionYObtenerParametros() {
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
        // var_dump("hola");
        // exit();
        verificarSesion();
    } else {
        $nombre_usuario = null;
        $user_id = null;
        $is_admin = false;
    }

    // Verificar si el parámetro 'administrar' está activado
    $administrar = isset($_GET['administrar']) && $_GET['administrar'] === 'true';

    // Obtener el número de artículos por página seleccionado por el usuario y almacenarlo en una cookie
    if (isset($_GET['posts_per_page'])) {
        $articulosPorPagina = (int)$_GET['posts_per_page'];
        setcookie('posts_per_page', $articulosPorPagina, time() + (86400 * 30), "/"); // La cookie expira en 30 días
    } elseif (isset($_COOKIE['posts_per_page'])) {
        $articulosPorPagina = (int)$_COOKIE['posts_per_page'];
    } else {
        $articulosPorPagina = 6; // Valor por defecto de 6
    }

    // Obtener la página actual y almacenarla en una cookie
    if (isset($_GET['page'])) {
        $pagina = (int)$_GET['page'];
        setcookie('current_page', $pagina, time() + (86400 * 30), "/"); // La cookie expira en 30 días
    } elseif (isset($_COOKIE['current_page'])) {
        $pagina = (int)$_COOKIE['current_page'];
    } else {
        $pagina = 1;
    }

    if ($pagina < 1) {
        $pagina = 1;
    }

    // Obtener el criterio de ordenación
    $orden = isset($_GET['orden']) ? $_GET['orden'] : 'nombre_asc'; // Por defecto, ordenar por nombre ascendente

    return [
        'nombre_usuario' => $nombre_usuario,
        'user_id' => $user_id,
        'is_admin' => $is_admin,
        'administrar' => $administrar,
        'articulosPorPagina' => $articulosPorPagina,
        'pagina' => $pagina,
        'orden' => $orden
    ];
}
function mostrarArticulos($articlesData, $administrar) {
    require_once __DIR__ . '../../../vista/animal/Mostrar.php';
    $_SESSION['administrar'] = $administrar;
    // Mostrar los artículos
    if ($articlesData['show_edit']) {
       
        listarArticulos($articlesData['articles'], 'editar');
    } else {
       
        listarArticulos($articlesData['articles']);
    }
}
?>