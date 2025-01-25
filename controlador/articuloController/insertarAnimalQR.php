<?php

require_once '../../controlador/userController/verificarSesion.php';
require_once '../../modelo/articulo/insertarAnimal.php';
require_once '../../controlador/errores/errores.php';

verificarSesion();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    function procesarFormularioQR()
    {
        $errores = [];
        $correcto = '';

        $nombre_comun = $_POST['nombre_comun'];
        $nombre_cientifico = $_POST['nombre_cientifico'];
        $descripcion = $_POST['descripcion'];
        $es_mamifero = isset($_POST['es_mamifero']) ? 1 : 0;

        if (empty($nombre_comun)) {
            $errores[] = 'El nombre común es obligatorio.';
        }

        if (empty($nombre_cientifico)) {
            $errores[] = 'El nombre científico es obligatorio.';
        }

        if (empty($descripcion)) {
            $errores[] = 'La descripción es obligatoria.';
        }

        
        $rutaImagenBD = null;

        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $rutaImagenes = __DIR__ . '/../../vista/imagenes/imagenes/';

            // Crear directorio si no existe
            if (!is_dir($rutaImagenes)) {
                mkdir($rutaImagenes, 0755, true);
            }

            $nombreArchivo = $_FILES['imagen']['name'];
            $rutaTemporal = $_FILES['imagen']['tmp_name'];
            $extensionesPermitidas = ['jpg', 'jpeg', 'png', 'gif'];
            $extensionArchivo = pathinfo($nombreArchivo, PATHINFO_EXTENSION);

            if (in_array(strtolower($extensionArchivo), $extensionesPermitidas)) {
                $nombreArchivoSeguro = uniqid('img_', true) . '.' . $extensionArchivo;
                $rutaDestino = $rutaImagenes . $nombreArchivoSeguro;

                if (move_uploaded_file($rutaTemporal, $rutaDestino)) {
                    // El archivo se ha subido correctamente, establecer la ruta
                    $rutaImagenBD = 'imagenes/imagenes/' . $nombreArchivoSeguro;
                }
            } else {
                $errores[] = 'Tipo de archivo no permitido. Solo se permiten imágenes JPG, JPEG, PNG y GIF.';
            }
        } elseif (isset($_FILES['imagen']) && $_FILES['imagen']['error'] !== UPLOAD_ERR_NO_FILE) {
            $errores[] = 'Error al subir la imagen.';
        }


        if (empty($errores)) {
            require_once '../../modelo/articulo/insertarAnimal.php';
            $usuario_id = $_SESSION['usuario_id'];

            $resultado = insertarCopiaAnimal_QR($nombre_comun, $nombre_cientifico, $descripcion, $rutaImagenBD, $usuario_id, $es_mamifero);

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
