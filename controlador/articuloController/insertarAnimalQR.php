<?php

require_once '../../controlador/userController/verificarSesion.php';
require_once '../../modelo/articulo/insertarAnimal.php';
require_once '../../controlador/errores/errores.php';

// verificarSesion();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    function procesarFormularioQR()
    {
        $id = (int)$_POST['id'];
        $errores = [];
        $correcto = '';
        $ruta_imagen = $_POST['ruta_imagen'];
        $nombre_comun = $_POST['nombre_comun'];
        $nombre_cientifico = $_POST['nombre_cientifico'];
        $descripcion = $_POST['descripcion'];
        $es_mamifero = isset($_POST['es_mamifero']) ? 1 : 0;
        $usuario_id = $_POST['usuario_id'];


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
            $usuario_id = $_SESSION['usuario_id'];

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
