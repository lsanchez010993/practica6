<?php
function leerAnimal()
{
    $result = [
        'id' => '',
        'nombre_comun' => '',
        'nombre_cientifico' => '',
        'descripcion' => '',
        'ruta_imagen' => '',
        'es_mamifero' => '',
        'errores' => []
    ];

    if (isset($_GET['id'])) {
        $result['id'] = $_GET['id'];
    } else {
        $result['errores'][] = "No se proporcionó un ID de animal válido.";
        return $result;
    }

    require_once "../../modelo/articulo/obtenerAnimalPor_Id.php";
    $animal = obtenerAnimalPor_Id($result['id']);

    if ($animal) {
        $result['nombre_comun'] = $animal['nombre_comun'];
        $result['nombre_cientifico'] = $animal['nombre_cientifico'];
        $result['descripcion'] = $animal['descripcion'];
        $result['ruta_imagen'] = $animal['ruta_imagen'];
        $result['es_mamifero'] = $animal['es_mamifero'];
    } else {
        $result['errores'][] = "El animal no fue encontrado.";
    }

    return $result; // Devolver los datos y los errores para usarlos en la vista
}

function controllerModificarAnimal()
{
    $errores = [];

    // Validar si se recibieron todos los campos necesarios
    if (!isset($_POST['nombre_comun'], $_POST['nombre_cientifico'], $_POST['descripcion'], $_POST['es_mamifero'])) {
        $errores[] = "Todos los campos son obligatorios.";
        return $errores;
    }

    $nombre_comun = trim($_POST['nombre_comun']);
    $nombre_cientifico = trim($_POST['nombre_cientifico']);
    $descripcion = trim($_POST['descripcion']);
    $es_mamifero = $_POST['es_mamifero'];

    // Validación de los campos
    if (empty($nombre_comun)) {
        $errores[] = "El campo 'Nombre Común' no puede estar vacío.";
    }
    if (empty($nombre_cientifico)) {
        $errores[] = "El campo 'Nombre Científico' no puede estar vacío.";
    }
    if (empty($descripcion)) {
        $errores[] = "El campo 'Descripción' no puede estar vacío.";
    }

    // Validación del campo es_mamifero (booleano)
    if ($es_mamifero !== '0' && $es_mamifero !== '1') {
        $errores[] = "Debe seleccionar si el animal es mamífero u ovíparo.";
    }

    // Si hay errores, devolver el array de errores
    if (!empty($errores)) {
        return $errores;
    }

    // Si no hay errores, retornar true para proceder con la actualización
    return true;
}

function actualizar_animal($id, $nombre_comun, $nombre_cientifico, $descripcion, $rutaImagen, $es_mamifero)
{
    require_once "../../modelo/articulo/insertarAnimal.php"; 

    $resultado = actualizarAnimal($id, $nombre_comun, $nombre_cientifico, $descripcion, $rutaImagen, $es_mamifero);

    if ($resultado === true) {
        return "El animal se actualizó correctamente.";
    } else {
        return "Hubo un error al actualizar el animal.";
    }
}
