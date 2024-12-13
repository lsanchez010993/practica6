<?php
// require_once 'controlador/errores/errores.php'; 
require_once __DIR__ . '../../../controlador/errores/errores.php';
?>
<script>
    function confirmarEliminacion() {
        return confirm("<?php echo Mensajes::CONFIRMAR_ACTUALIZACION ?>");
    }
</script>
<?php

// Función para listar los artículos y centrarlos en la página
function listarArticulos($animales, $accion = null, $resultadosBusqueda=null)
{
    

    
    if (!isset($resultadosBusqueda)) {
        $prefijoRutaImagen = 'vista/';
    } else {
        
        $prefijoRutaImagen = '../../vista/';
    }

   
    
    
    $prefijoIconoModificar = './';
    $prefijoRutaModificar = './';
    $prefijoIconoEliminar = './';
    $prefijoRutaEliminar = './';

    //comprueba si el usuario ha iniciado sesion
    if (isset($_SESSION['nombre_usuario'])) {
        $nombre_usuario = $_SESSION['nombre_usuario'];
    }

    if ($resultadosBusqueda && !empty($animales)){
        echo "<h1>Animales encontrados</h1>";
    }
    if ($resultadosBusqueda && empty($animales)){
        echo "<h1>No se han encontrado animales</h1>";
    }

    // Verificar si hay artículos y mostrarlos

    if (!empty($animales)) {
        if ($accion == 'editar') {
            echo "<h1>Mis artículos</h1>";
        } else {
            echo '<h1>Todos los artículos</h1>';
        }

        // Iniciar el contenedor de tarjetas
        echo '<div class="contenedor-tarjetas">';

        foreach ($animales as $animal) {
            require_once __DIR__ . '../../../modelo/articulo/obtenerNombreUsuario.php';


            echo '<div class="tarjeta">';

            if (isset($nombre_usuario) && isset($_SESSION['administrar'])) {
                if ($nombre_usuario === 'admin') {
                    $nombreUsuario = obtenerNombreUsuarioPorAnimal($animal['usuario_id']);
                    echo '<h2><strong class="nombre_comun">Nombre de usuario: </strong>' . htmlspecialchars($nombreUsuario) . '</h2>';
                }
            }
            echo '<h2><strong class="nombre_comun">Nombre común: </strong>' . htmlspecialchars($animal['nombre_comun']) . '</h2>';
            echo '<h3><span class="nombre_cientifico">Nombre científico: </span>' . htmlspecialchars($animal['nombre_cientifico']) . '</h3>';

            // Añadir el campo 'es_mamifero'
            $esMamiferoTexto = ($animal['es_mamifero'] == 1) ? 'Sí' : 'No';
            echo '<p><strong>Mamífero: </strong>' . htmlspecialchars($esMamiferoTexto) . '</p>';

            // Verificar y mostrar la imagen del animal si está presente
            if (!empty($animal['ruta_imagen'])) {
                echo '<img src="' . htmlspecialchars($prefijoRutaImagen . $animal['ruta_imagen']) . '" alt="Imagen del artículo" class="tarjeta-imagen">';
            }

            echo '<p class="descripcion">' . htmlspecialchars($animal['descripcion']) . '</p>';

            // Opciones de edición si corresponde
            if ($accion == 'editar') {
                echo "<a href='" . $prefijoRutaEliminar . "modelo/articulo/eliminarAnimal.php?id=" . $animal['id'] . "' onclick='return confirmarEliminacion()'>
                        <img src='" . $prefijoIconoEliminar . "vista/imagenes/iconos/eliminar.png' alt='Eliminar' width='20' height='20'>
                      </a>";

                echo "<a href='" . $prefijoRutaModificar . "vista/animal/modificarAnimal.vista.php?id=" . $animal['id'] . "'>
                        <img src='" . $prefijoIconoModificar . "vista/imagenes/iconos/editar.png' alt='Editar' width='20' height='20'>
                      </a>";
            }


            echo '</div>'; // Cierra el div de la tarjeta
        }


        echo '</div>';
    } else {
        if (!$resultadosBusqueda && empty($animales)){
            echo Mensajes::NO_ANIMALES;
        }
        
    }
}
?>
<script>
    function confirmarEliminacion() {
        return confirm("<?php echo Mensajes::CONFIRMAR_ACTUALIZACION ?>");
    }
</script>

<?php

require_once __DIR__ . '../../../controlador/errores/errores.php';
?>