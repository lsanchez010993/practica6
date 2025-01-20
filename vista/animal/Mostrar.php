<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Listado de Animales</title>
    
    <link rel="stylesheet" href="vista/estils/mostrarAnimales.css">


</head>

<body>

<div id="qr-modal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="cerrarModal()">&times;</span>
        <!-- Aquí se inyecta dinámicamente el contenido del artículo -->
        <div id="modal-body"></div>
    </div>
</div>

</body>
</html>

<?php
// Ajusta la ruta según tu proyecto
require_once __DIR__ . '../../../controlador/errores/errores.php';
require_once __DIR__ . '../../../vendor/autoload.php';

use chillerlan\QRCode\QRCode;

/**
 * Función para listar los artículos
 */
function listarArticulos($animales, $accion = null, $resultadosBusqueda = null)
{
    $prefijoRutaImagen      = 'vista/';

    // Comprueba si el usuario ha iniciado sesión
    if (isset($_SESSION['nombre_usuario'])) {
        $nombre_usuario = $_SESSION['nombre_usuario'];
    }

    // Títulos
    if (!empty($animales)) {
        if ($accion === 'editar') {
            echo "<h1>Mis fichas</h1>";
        } else {
            if (!$resultadosBusqueda) {
                echo '<h1>Todos los animales</h1>';
            }
        }

        // Contenedor de tarjetas
        echo '<div class="contenedor-tarjetas">';

        // Recorremos cada animal
        foreach ($animales as $animal) {

            // Ajusta la ruta al archivo según tu estructura
            require_once __DIR__ . '../../../modelo/articulo/obtenerNombreUsuario.php';

            echo '<div class="tarjeta">';

            // Mostrar el usuario si es admin
            if (isset($nombre_usuario) && isset($_SESSION['administrar'])) {
                if ($nombre_usuario === 'admin') {
                    $nombreUsuario = obtenerNombreUsuarioPorAnimal($animal['usuario_id']);
                    echo '<h2><strong class="nombre_comun">Usuario: </strong>'
                        . htmlspecialchars($nombreUsuario) . '</h2>';
                }
            }

            // Datos del animal
            echo '<h2><strong class="nombre_comun">Nombre común: </strong>'
                . htmlspecialchars($animal['nombre_comun']) . '</h2>';
            echo '<h3><span class="nombre_cientifico">Nombre científico: </span>'
                . htmlspecialchars($animal['nombre_cientifico']) . '</h3>';

            // Campo mamífero
            $esMamiferoTexto = ($animal['es_mamifero'] == 1) ? 'Sí' : 'No';
            echo '<p><strong>Mamífero: </strong>' . htmlspecialchars($esMamiferoTexto) . '</p>';

            // Imagen del animal si existe
            if (!empty($animal['ruta_imagen'])) {
                echo '<img src="' . htmlspecialchars($prefijoRutaImagen . $animal['ruta_imagen'])
                    . '" alt="Imagen del artículo" class="tarjeta-imagen">';
            }

            // Descripción
            echo '<p class="descripcion">' . htmlspecialchars($animal['descripcion']) . '</p>';
            // Generar QR del artículo
            $qrURL  = 'http://localhost/practicas/practica6/vista/animal/mostrarQR.php?id=' . $animal['id'];
            $qr = (new QRCode)->render($qrURL);
            // Ícono QR para abrir el modal
            echo '<div class="qr-icon">';
            echo '<img src="vista/imagenes/iconos/qr-icon.png" alt="Icono QR" width="30" height="30" '
                . 'onclick="mostrarModal(' . $animal['id'] . ')" title="Ver QR"/>';
            echo '</div>';

            // Opciones de edición
            if ($accion === 'editar') {
                echo "<a href='modelo/articulo/eliminarAnimal.php?id=" . $animal['id']
                    . "' onclick='return confirmarEliminacion()'>"
                    . "<img src='vista/imagenes/iconos/eliminar.png' "
                    . "alt='Eliminar' width='20' height='20'></a>";

                echo "<a href='vista/animal/modificarAnimal.vista.php?id="
                    . $animal['id'] . "'>"
                    . "<img src='vista/imagenes/iconos/editar.png' "
                    . "alt='Editar' width='20' height='20'></a>";
            }

            // Contenedor oculto para el modal
            echo '<div id="modal-data-' . $animal['id'] . '" style="display:none;">';
            // Encabezados
            echo '<h2>' . htmlspecialchars($animal['nombre_comun']) . '</h2>';
            echo '<h3>' . htmlspecialchars($animal['nombre_cientifico']) . '</h3>';
            echo '<p>' . htmlspecialchars($animal['descripcion']) . '</p>';

            // Imagen del animal en el modal (opcional, si quieres volverla a mostrar)
            if (!empty($animal['ruta_imagen'])) {
                echo '<br><img class="imagen_modal" src="' . htmlspecialchars($prefijoRutaImagen . $animal['ruta_imagen'])
                    . '" alt="Imagen del artículo" ><br>';
            }
            // Imagen QR en el modal (generada con la librería)

            echo 'QR:' . '<img class="imagen_qr_modal" src="' . $qr . '" alt="QR Code" >';

            echo '</div>';

            echo '</div>'; // Cierre de .tarjeta
        } // Fin del foreach

        echo '</div>'; // Cierre de .contenedor-tarjetas
    } else {
        // Mensaje si no hay animales
        if (!$resultadosBusqueda && empty($animales)) {
            echo Mensajes::NO_ANIMALES;  // Ajusta según tu clase Mensajes
        }
    }
}
?>
<script>
    // Confirmar eliminación
    function confirmarEliminacion() {
        return confirm("<?php echo Mensajes::CONFIRMAR_ACTUALIZACION ?>");
    }

    // Mostrar el modal con los datos del artículo
    function mostrarModal(id) {
        const modalData = document.getElementById(`modal-data-${id}`); // Uso de backticks para la interpolación
        const modalBody = document.getElementById('modal-body');

        // Copiamos el contenido oculto de "modal-data-id" al cuerpo del modal
        modalBody.innerHTML = modalData.innerHTML;

        // Mostramos el modal
        document.getElementById('qr-modal').style.display = 'block';
    }

    // Cerrar el modal
    function cerrarModal() {
        document.getElementById('qr-modal').style.display = 'none';
    }
</script>