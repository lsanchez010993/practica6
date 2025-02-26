<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Menú principal</title>

    <link rel="stylesheet" href="vista/estils/vistaAnimals.css">
    <link rel="stylesheet" href="vista/estils/mostrarAnimales.css">
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
        $animalesCopiados = (isset($_GET['animalesCopiados']) && $_GET['animalesCopiados'] === 'true');
        $todosAnimales = (isset($_GET['todosAnimales']) && $_GET['todosAnimales'] === 'true');
        $animalesAPI = (isset($_GET['animalesAPI']) && $_GET['animalesAPI'] === 'true');
        


        $letra = isset($_GET['letter']) ? $_GET['letter'] : null;





        if (!$animalesAPI){
            mostrarOrdenForm($pagina, $articulosPorPagina, $administrar, $orden);
        }
      


        mostrarBotones($params['user_id']);


        ?>



        <section class="articles">
           
                <?php
                $animales = $animalesData['animales'];

                if (isset($resultadosBusqueda)) {
                    $animales = $resultadosBusqueda;
                }
               
               
                    listarArticulosController($animales, $animalesData['show_edit'], $params['todosAnimales']);
                


                ?>
           
        </section>
        <?php
        mostrarPostsPerPageForm($pagina, $orden, $articulosPorPagina, $administrar, $animalesCopiados, $todosAnimales, $animalesAPI, $letra);

        mostrarPaginacion($totalArticulos, $pagina, $articulosPorPagina, $orden, $administrar, $animalesCopiados, $todosAnimales);
        ?>
    </div>
    <script src="controlador/articuloController/ajax.js"></script>
</body>

</html>