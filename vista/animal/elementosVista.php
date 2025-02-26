<?php
require_once __DIR__ . '../../../controlador/articuloController/vistaAnimalesController.php';

function mostrarOrdenForm($pagina, $articulosPorPagina, $administrar = false, $orden = '')
{
?>
    <div class="desplegable_ordenacion">
        <form method="GET" action="">
            <label for="orden">Ordenar por:</label>
            <select name="orden" id="orden" onchange="this.form.submit()">
                <option value="nombre_asc" <?php if ($orden == 'nombre_asc') echo 'selected'; ?>>Nombre (Ascendente)</option>
                <option value="nombre_desc" <?php if ($orden == 'nombre_desc') echo 'selected'; ?>>Nombre (Descendente)</option>
                <option value="tipo_mamifero" <?php if ($orden == 'tipo_mamifero') echo 'selected'; ?>>Tipo (Mamíferos primero)</option>
                <option value="tipo_oviparo" <?php if ($orden == 'tipo_oviparo') echo 'selected'; ?>>Tipo (Ovíparos primero)</option>
            </select>
            <input type="hidden" name="page" value="<?php echo htmlspecialchars($pagina); ?>">
            <input type="hidden" name="posts_per_page" value="<?php echo htmlspecialchars($articulosPorPagina); ?>">
            <?php if ($administrar): ?>
                <input type="hidden" name="administrar" value="true">
            <?php endif; ?>
        </form>
    </div>
<?php
}

function mostrarPostsPerPageForm($pagina, $orden, $articulosPorPagina, $administrar = false, $animalesCopiados = null, $todosAnimales = null, $animalesAPI = null, $letra = null)
{
?>
    <div class="desplegable_paginacion">
        <form method="GET" action="">
            <label for="posts_per_page">Artículos por página:</label>
            <select name="posts_per_page" id="posts_per_page" onchange="this.form.submit()">
                <option value="6" <?php if ($articulosPorPagina == 6) echo 'selected'; ?>>6</option>
                <option value="12" <?php if ($articulosPorPagina == 12) echo 'selected'; ?>>12</option>
                <option value="16" <?php if ($articulosPorPagina == 16) echo 'selected'; ?>>16</option>
            </select>
            <input type="hidden" name="page" value="<?php echo htmlspecialchars($pagina); ?>">
            <input type="hidden" name="orden" value="<?php echo htmlspecialchars($orden); ?>">
            <?php if ($administrar): ?>
                <input type="hidden" name="administrar" value="true">
            <?php endif; ?>
            <?php if ($animalesCopiados): ?>
                <input type="hidden" name="animalesCopiados" value="true">
            <?php endif; ?>
            <?php if ($todosAnimales): ?>
                <input type="hidden" name="todosAnimales" value="true">
            <?php endif; ?>
            <?php if ($animalesAPI): ?>
                <input type="hidden" name="animalesAPI" value="true">
                <input type="hidden" name="letter" value="<?php echo htmlspecialchars($letra); ?>">

            <?php endif; ?>
       
        </form>
    </div>
<?php
}
function mostrarPaginacion($totalArticles, $pagina, $articulosPorPagina, $orden, $administrar = false, $animalesCopiados, $todosAnimales = false)
{
    require_once __DIR__ . '../../../modelo/articulo/contarAnimal.php';

    // Calcular el número total de páginas
    $totalPages = ceil($totalArticles / $articulosPorPagina);

    // Parámetros adicionales para mantener en los enlaces
    $additionalParams = '';

    // Ejemplo para 'todosAnimales' o 'animalesCopiados'
    if (isset($_GET['todosAnimales'])) {
        $additionalParams .= '&todosAnimales=' . urlencode($_GET['todosAnimales']);
    }
    if (isset($_GET['animalesCopiados'])) {
        $additionalParams .= '&animalesCopiados=' . urlencode($_GET['animalesCopiados']);
    }
    if (isset($_GET['animalesAPI'])) {
        $additionalParams .= '&animalesAPI=' . urlencode($_GET['animalesAPI']);
    }

    // También mantienes otros parámetros que ya tenías
    $additionalParams .= '&posts_per_page=' . $articulosPorPagina;
    $additionalParams .= '&orden=' . urlencode($orden);

    if ($animalesCopiados) {
        $additionalParams .= '&animalesCopiados=true';
    }


    // Agregar el parámetro "administrar" si es true
    if ($administrar) {
        $additionalParams .= '&administrar=true';
    }
    if ($todosAnimales) {
        $additionalParams .= '&todosAnimales=true';
    }

    // Iniciar la paginación
    echo '<section class="paginacio">';
    echo '<ul>';

    // Botón "Anterior"
    if ($pagina > 1) {
        echo '<li><a href="?page=' . ($pagina - 1) . $additionalParams . '">&laquo;</a></li>';
    } else {
        echo '<li class="disabled"><a href="#">&laquo;</a></li>';
    }

    // Enlaces de páginas
    for ($i = 1; $i <= $totalPages; $i++) {
        if ($pagina == $i) {
            echo '<li class="active"><a href="?page=' . $i . $additionalParams . '">' . $i . '</a></li>';
        } else {
            echo '<li><a href="?page=' . $i . $additionalParams . '">' . $i . '</a></li>';
        }
    }

    // Botón "Siguiente"
    if ($pagina < $totalPages) {
        echo '<li><a href="?page=' . ($pagina + 1) . $additionalParams . '">&raquo;</a></li>';
    } else {
        echo '<li class="disabled"><a href="#">&raquo;</a></li>';
    }

    echo '</ul>';
    echo '</section>';
}

function mostrarBotones($user_id)
{
    // Botón de "Administrar artículos" (solo si el usuario tiene permisos de administración)
    if (isset($_SESSION['administrar'])) {
        echo '<button class="boton_vista" onclick="location.href=\'index.php?administrar=true\'">Administrar artículos</button>';
    }

    // Botones para usuarios autenticados
    if ($user_id !== null) {
        if (!isset($_SESSION['administrar'])) {
            echo '<button class="boton_vista" onclick="location.href=\'index.php?todosAnimales=true\'">Todos los animales</button>';
        }
        echo '<button class="boton_vista" onclick="location.href=\'index.php\'">Mis animales</button>';
        echo '<button class="boton_vista" onclick="location.href=\'index.php?animalesCopiados=true\'">Animales copiados</button>';
    }

    // Botón de "Animales API" (siempre visible)
    echo '<button class="boton_vista" onclick="location.href=\'index.php?animalesAPI=true&letter=a\'">Animales API</button>';

    if ($user_id === null) {

        echo '<button class="boton_vista" onclick="location.href=\'index.php\'">Animales de la web</button>';
    }
}



?>