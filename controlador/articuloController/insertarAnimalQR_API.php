<?php

require_once '../../controlador/userController/verificarSesion.php';
require_once '../../modelo/articulo/insertarAnimal.php';
require_once '../../controlador/errores/errores.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    function procesarFormularioQR()
    {
        $usuario_id = $_SESSION['usuario_id'] ?? null;
        
        // Manejo seguro de variables para evitar warnings
        $id = isset($_POST['id']) ? (int)$_POST['id'] : null;
        $ruta_imagen = $_POST['ruta_imagen'] ?? 'ruta_por_defecto.jpg'; // Imagen por defecto

        // var_dump($ruta_imagen);

        // exit();
        

        $nombre_comun = $_POST['nombre_comun'] ?? 'Desconocido';
        $nombre_cientifico = $_POST['nombre_cientifico'] ?? 'Desconocido';
        $descripcion = $_POST['descripcion'] ?? 'Desconocido';
        $es_mamifero = isset($_POST['es_mamifero']) ? 1 : 0;

        $errores = [];
        $correcto = '';

        if (empty($nombre_comun)) {
            $errores[] = 'El nombre común es obligatorio.';
        }

        if (empty($nombre_cientifico)) {
            $errores[] = 'El nombre científico es obligatorio.';
        }

        if (empty($descripcion)) {
            $errores[] = 'La descripción es obligatoria.';
        }

        if (empty($errores)) {
            require_once '../../modelo/articulo/insertarAnimal.php';
            $usuario_id = $_SESSION['usuario_id'] ?? null;

          
            $resultado = insertarCopiaAnimal_QR($nombre_comun, $nombre_cientifico, $descripcion, $ruta_imagen, $usuario_id, $es_mamifero);

            if ($resultado === true) {
                require_once '../../controlador/errores/errores.php';
                $correcto = Mensajes::EXITO_INSERTAR_ANIMAL;
            } else {
                $errores[] = 'Error al insertar el artículo en la base de datos.';
            }
        }

        return [$errores, $correcto];
    }
}
