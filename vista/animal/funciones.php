<?php
require_once __DIR__ .'../../../controlador/articuloController/manejarDatos.php';

function mostrarOrdenForm($pagina, $articulosPorPagina, $administrar = false, $orden = '') {
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

function mostrarPostsPerPageForm($pagina, $orden, $articulosPorPagina, $administrar = false) {
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
        </form>
    </div>
    <?php
}
function mostrarPaginacion($totalArticles, $pagina, $articulosPorPagina, $orden, $administrar = false) 
{
    require_once __DIR__ . '../../../modelo/articulo/contarAnimal.php';

    // Calcular el número total de páginas
    $totalPages = ceil($totalArticles / $articulosPorPagina);

    // Parámetros adicionales para mantener en los enlaces
    $additionalParams = '&posts_per_page=' . $articulosPorPagina . '&orden=' . urlencode($orden);

    // Agregar el parámetro "administrar" si es true
    if ($administrar) {
        $additionalParams .= '&administrar=true';
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


?>
