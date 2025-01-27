<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Menú principal</title>

    <link rel="stylesheet" href="vista/estils/vistaAnimals.css">
</head>

<body>

    <div class="contenidor">
        <?php

        require_once __DIR__ . '/../../controlador/articuloController/vistaAnimalesController.php';
        require_once __DIR__ . '/../../vista/animal/elementosVista.php';
        require_once __DIR__ . '../../../controlador/articuloController/mostrarAnimalesController.php';
        require_once __DIR__ . '../../../controlador/articuloController/buscarPorNombre.php';
        require_once __DIR__ . '../../../controlador/errores/errores.php';

        $params = iniciarSesionYObtenerParametros();
        $animalesData = obtenerArticulosYTotal($params);

        //    var_dump($params['todosAnimales']);

        $totalArticulos = $animalesData['totalArticulos'];
        $pagina = isset($_GET['page']) ? (int) $_GET['page'] : 1;

     
        $articulosPorPagina = isset($_GET['posts_per_page']) ? (int) $_GET['posts_per_page'] : 6;
        $orden = $_GET['orden'] ?? 'nombre_asc';
        $administrar = (isset($_GET['administrar']) && $_GET['administrar'] === 'true');



        mostrarOrdenForm($pagina, $articulosPorPagina, $administrar, $orden);


        mostrarBotones($params['user_id']);


        ?>



        <section class="articles">
            <ul>
                <?php
                $animales = $animalesData['animales'];

                if (isset($resultadosBusqueda)) {
                    $animales = $resultadosBusqueda;
                }
                listarArticulosController($animales, $animalesData['show_edit'], $params['todosAnimales']);


                ?>
            </ul>
        </section>
        <?php
        mostrarPostsPerPageForm($pagina, $orden, $articulosPorPagina, $administrar);

        mostrarPaginacion($totalArticulos, $pagina, $articulosPorPagina, $orden, $administrar);
        ?>
    </div>
    <script src="controlador/articuloController/ajax.js"></script>
</body>

</html>