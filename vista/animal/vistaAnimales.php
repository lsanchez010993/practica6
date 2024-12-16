<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Menú principal</title>
    <link rel="stylesheet" href="vista/estils/vistaAnimals.css">
    <!-- <link rel="stylesheet" href="../../vista/estils/estils_Index.css"> -->

</head>

<body>

    <div class="contenidor">
        <?php
        require_once __DIR__ . '../../../vista/animal/funciones.php';
        // Obtener los parámetros iniciales
        $params = iniciarSesionYObtenerParametros();

        // Obtener los artículos y datos de paginación


        $articlesData = obtenerArticulosYTotal($params);




        // Mostrar la sección de artículos
        ?>
        <section class="articles">
            <ul>

                <?php
                if (isset($resultadosBusqueda)) {
                    // var_dump("hola");
                    // exit();
                    require_once __DIR__ . '../../animal/Mostrar.php';
                    listarArticulos($resultadosBusqueda, null, true);
                } else {
                    // var_dump("hola");
                    // exit();
                    mostrarArticulos($articlesData, $params['administrar']);
                }

                ?>
            </ul>
        </section>


        <!-- Menú desplegable para ordenar los artículos -->
        <?php
        if (!isset($resultadosBusqueda)) {
            $totalArticulos = $articlesData["totalArticulos"];
            $pagina = isset($_GET['page']) ? intval($_GET['page']) : 1;
            $articulosPorPagina = isset($_GET['posts_per_page']) ? intval($_GET['posts_per_page']) : 6;
            $orden = isset($_GET['orden']) ? $_GET['orden'] : 'nombre_asc';
            $administrar = isset($_GET['administrar']) && $_GET['administrar'] == 'true';


            mostrarOrdenForm($pagina, $articulosPorPagina, $administrar, $orden);
            mostrarPostsPerPageForm($pagina, $orden, $articulosPorPagina, $administrar);
            // Mostrar la paginación
            mostrarPaginacion($totalArticulos, $pagina, $articulosPorPagina, $orden, $administrar);
        }


        ?>


    </div>
    <script src="controlador/articuloController/ajax.js"></script>
</body>

</html>