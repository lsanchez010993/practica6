<?php
require_once __DIR__ . '../../../modelo/articulo/animalesNoPublicados.php';

$animalesNoPublicados = obtenerAnimalesNoPublicados();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    // Obtenemos el id y lo convertimos a entero
    $id = intval($_POST['id']);

    // Llamamos a la función para publicar el animal
    $resultado = publicarAnimal($id);

    // Mensaje de confirmación o error (puedes redirigir o mostrar un mensaje)
    if ($resultado > 0) {
        echo "<p>El animal con ID $id se ha publicado correctamente.</p>";
    } else {
        echo "<p>Error al publicar el animal con ID $id.</p>";
    }
}