<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Listado de Animales</title>
    <link rel="stylesheet" href="vista/estils/mostrarAnimales.css">
    <script defer type="module" src="vista/js/QR.js"></script>
    <script>
        function confirmarEliminacion() {
            return confirm("¿Estás seguro de que deseas eliminar este elemento?");
        }
    </script>
</head>

<body>

    <!-- Títulos -->
    <?php if (!empty($animales)): ?>

        <h1>

            <?php
            $animalesAPI = isset($_GET['animalesAPI'])
                ? filter_var($_GET['animalesAPI'], FILTER_VALIDATE_BOOLEAN)
                : false;

            if ($show_edit && !$animalesCopiados) {
                echo "Mis fichas";
            } elseif ($animalesCopiados) {
                echo "Animales copiados";
            } elseif ($animalesAPI) {
                echo "Todos los gatos:";
            } else  echo "Todos los animales:";
            ?>
        </h1>
        <?php
        if ($animalesAPI) {
            require_once __DIR__ . '../../../controlador/articuloController/apiGatosController.php';

            $controller = new CatController();
            // var_dump("a1ui");
            $controller->showCatsByLetter();
        }

        ?>

        <div class="contenedor-tarjetas">
            <?php foreach ($animales as $animal): ?>
                <?php
                //   var_dump("animalesCopiados");

                if ($animalesAPI) {
                   
                    echo "<div class='tarjeta'>";
                    
                    echo "<h2><strong>Nombre común: </strong>" . htmlspecialchars($animal['name']) . "</h2>";
                    echo "<h3><span>Nombre científico: </span>" . htmlspecialchars($animal['scientific_name'] ?? 'No disponible') . "</h3>";
                    echo "<p><strong>Mamífero: </strong>" . (isset($animal['is_mammal']) && $animal['is_mammal'] == 1 ? 'Sí' : 'No') . "</p>";
                
                    if (!empty($animal['image_link'])) {
                        echo "<img src='" . htmlspecialchars($animal['image_link']) . "' alt='Imagen del animal' class='tarjeta-imagen'>";
                    }
                
                    echo "<p class='descripcion'>" . htmlspecialchars($animal['description'] ?? 'Sin descripción') . "</p>";
                
                    // Corregido el bloque del código QR
                    echo "<div class='qr-icon'>
                            <img src='" . htmlspecialchars($animal["qrAPI"]) . "' 
                                 alt='Código QR' width='150' height='150' 
                                 onclick='mostrarModal(4)' 
                                 title='Ver QR' />
                          </div>";
                
                    echo "<hr>";
                    echo "</div>";
                    continue;
                }
                
                

                ?>
                <div class="tarjeta">
                    <?php if ($esAdmin && isset($animal['nombreUsuario'])): ?>
                        <h2><strong>Usuario: </strong><?php echo htmlspecialchars($animal['nombreUsuario']); ?></h2>
                    <?php endif; ?>

                    <h2><strong>Nombre común: </strong><?php echo htmlspecialchars($animal['nombre_comun']); ?></h2>
                    <h3><span>Nombre científico: </span><?php echo htmlspecialchars($animal['nombre_cientifico']); ?></h3>
                    <p><strong>Mamífero: </strong><?php echo htmlspecialchars(($animal['es_mamifero'] == 1) ? 'Sí' : 'No'); ?></p>

                    <?php if (!empty($animal['ruta_imagen'])): ?>
                        <img src="<?php echo htmlspecialchars($animal['ruta_imagen']); ?>"
                            alt="Imagen del artículo" class="tarjeta-imagen">
                    <?php endif; ?>

                    <p class="descripcion"><?php echo htmlspecialchars($animal['descripcion']); ?></p>

                    <div class="qr-icon">
                        <img src="vista/imagenes/iconos/qr-icon.png"
                            alt="Icono QR" width="30" height="30"
                            onclick="mostrarModal(<?php echo $animal['id']; ?>)" title="Ver QR" />
                    </div>

                    <?php if ($show_edit && !$animalesCopiados): ?>
                        <a href="modelo/articulo/eliminarAnimal.php?id=<?php echo $animal['id']; ?>"
                            onclick="return confirmarEliminacion()">
                            <img src="vista/imagenes/iconos/eliminar.png"
                                alt="Eliminar" width="20" height="20">
                        </a>

                        <a href="vista/animal/modificarAnimal.vista.php?id=<?php echo $animal['id']; ?>">
                            <img src="vista/imagenes/iconos/editar.png"
                                alt="Editar" width="20" height="20">
                        </a>
                    <?php endif; ?>

                    <!-- Si $show_edit && $animalesCopiados estan activos -->
                    <?php if ($show_edit && $animalesCopiados): ?>
                        <a href="modelo/articulo/eliminarAnimal.php?id=<?php echo $animal['id']; ?>&animalesCopiados=true"
                            onclick="return confirmarEliminacion()">
                            <img src="vista/imagenes/iconos/eliminar.png" alt="Eliminar" width="20" height="20">
                        </a>

                    <?php endif; ?>

                    <div id="modal-data-<?php echo $animal['id']; ?>" style="display:none;">
                        <h2><?php echo htmlspecialchars($animal['nombre_comun']); ?></h2>
                        <h3><?php echo htmlspecialchars($animal['nombre_cientifico']); ?></h3>
                        <p><?php echo htmlspecialchars($animal['descripcion']); ?></p>



                        <!-- Imagen del animal (si existe) -->
                        <?php if (!empty($animal['ruta_imagen'])): ?>
                            <br>
                            <img class="imagen_modal"
                                id="rutaImagen-<?php echo $animal['id']; ?>"
                                src="<?php echo htmlspecialchars( $animal['ruta_imagen']); ?>"
                                alt="Imagen del artículo">
                            <br>
                        <?php endif; ?>

                        <p>Selecciona los datos que quieres obtener con el QR</p><br>


                        <?php if (isset($_SESSION['usuario_id']) && !empty($_SESSION['usuario_id'])): ?>
                            <input type="checkbox" class="checkbox-qr" id="nombre-comun-<?php echo htmlspecialchars($animal['id']); ?>" checked>
                            <label for="nombre-comun-<?php echo htmlspecialchars($animal['id']); ?>">Nombre común</label><br>

                            <input type="checkbox" class="checkbox-qr" id="nombre-cientifico-<?php echo htmlspecialchars($animal['id']); ?>" checked>
                            <label for="nombre-cientifico-<?php echo htmlspecialchars($animal['id']); ?>">Nombre científico</label><br>

                            <input type="checkbox" class="checkbox-qr" id="descripcion-<?php echo htmlspecialchars($animal['id']); ?>" checked>
                            <label for="descripcion-<?php echo htmlspecialchars($animal['id']); ?>">Descripción</label><br>

                            <!-- Cambiamos el ID para que use el id del animal -->
                            <input type="checkbox" class="checkbox-qr" id="usuario-<?php echo htmlspecialchars($animal['id']); ?>" checked>
                            <label for="usuario-<?php echo htmlspecialchars($animal['id']); ?>">Usuario ID</label><br>
                        <?php endif; ?>




                        <br><br>
                        <h3>QR Code</h3>
                        <p>Escanea el código QR para obtener los datos</p>
                        <br>
                        <!-- <img id="insertarQR" src="" alt="QR Code" /> -->
                        <img id="insertarQR" class="imagen_qr_modal" src="<?php echo $animal['qr']; ?>" alt="QR Code">






                    </div>
                </div>

            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <h1>No se han encontrado animales</h1>
    <?php endif; ?>



    <div id="qr-modal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="cerrarModal()">&times;</span>
            <div id="modal-body"></div>
        </div>
    </div>





</body>

</html>