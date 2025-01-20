<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Listado de Animales</title>
    <link rel="stylesheet" href="vista/estils/mostrarAnimales.css">
</head>

<body>

    <!-- Títulos -->
    <?php if (!empty($animales)): ?>
        <h1><?php echo $show_edit ? "Mis fichas" : "Todos los animales:"; ?></h1>

        <div class="contenedor-tarjetas">
            <?php foreach ($animales as $animal): ?>
                <div class="tarjeta">
                    <?php if ($esAdmin && isset($animal['nombreUsuario'])): ?>
                        <h2><strong>Usuario: </strong><?php echo htmlspecialchars($animal['nombreUsuario']); ?></h2>
                    <?php endif; ?>

                    <h2><strong>Nombre común: </strong><?php echo htmlspecialchars($animal['nombre_comun']); ?></h2>
                    <h3><span>Nombre científico: </span><?php echo htmlspecialchars($animal['nombre_cientifico']); ?></h3>
                    <p><strong>Mamífero: </strong><?php echo htmlspecialchars(($animal['es_mamifero'] == 1) ? 'Sí' : 'No'); ?></p>

                    <?php if (!empty($animal['ruta_imagen'])): ?>
                        <img src="<?php echo htmlspecialchars($prefijoRutaImagen . $animal['ruta_imagen']); ?>" 
                             alt="Imagen del artículo" class="tarjeta-imagen">
                    <?php endif; ?>

                    <p class="descripcion"><?php echo htmlspecialchars($animal['descripcion']); ?></p>

                    <div class="qr-icon">
                        <img src="vista/imagenes/iconos/qr-icon.png" 
                             alt="Icono QR" width="30" height="30" 
                             onclick="mostrarModal(<?php echo $animal['id']; ?>)" title="Ver QR" />
                    </div>

                    <?php if ($show_edit): ?>
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

                    <div id="modal-data-<?php echo $animal['id']; ?>" style="display:none;">
                        <h2><?php echo htmlspecialchars($animal['nombre_comun']); ?></h2>
                        <h3><?php echo htmlspecialchars($animal['nombre_cientifico']); ?></h3>
                        <p><?php echo htmlspecialchars($animal['descripcion']); ?></p>

                        <?php if (!empty($animal['ruta_imagen'])): ?>
                            <br>
                            <img class="imagen_modal" 
                                 src="<?php echo htmlspecialchars($prefijoRutaImagen . $animal['ruta_imagen']); ?>" 
                                 alt="Imagen del artículo">
                            <br>
                        <?php endif; ?>

                        <p>QR:</p>
                        <img class="imagen_qr_modal" src="<?php echo $animal['qr']; ?>" alt="QR Code">
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <h1>No se han encontrado animales</h1>
    <?php endif; ?>

    <script>
        function confirmarEliminacion() {
            return confirm("¿Estás seguro de que deseas eliminar este artículo?");
        }

        function mostrarModal(id) {
            const modalData = document.getElementById(`modal-data-${id}`);
            const modalBody = document.getElementById('modal-body');
            modalBody.innerHTML = modalData.innerHTML;
            document.getElementById('qr-modal').style.display = 'block';
        }

        function cerrarModal() {
            document.getElementById('qr-modal').style.display = 'none';
        }
    </script>

    <div id="qr-modal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="cerrarModal()">&times;</span>
            <div id="modal-body"></div>
        </div>
    </div>

</body>

</html>
