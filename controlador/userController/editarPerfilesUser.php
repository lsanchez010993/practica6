<?php
// controlador/editarPerfilControlador.php

session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

require_once __DIR__.'../../../modelo/user/editarUsuarios.php';

$id = $_SESSION['usuario_id'];
$usuario = obtenerDatosUsuario($id);

if (!$usuario) {
    echo "No se pudieron obtener los datos del usuario.";
    exit();
}

$error = '';
$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_usuario = trim($_POST['nombre_usuario']);
    $nombre = trim($_POST['nombre']);
    $apellido = trim($_POST['apellido']);
    $avatar = $usuario['avatar']; // Avatar actual por defecto

    $destinationDirectory = __DIR__ . '/../../vista/imagenes/fotosPerfil/';

    if (!is_dir($destinationDirectory)) {
        mkdir($destinationDirectory, 0755, true);
    }
    

    


    // Manejar el archivo de imagen si se subió uno
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
        $nombreArchivo = uniqid('avatar_') . '_' . basename($_FILES['avatar']['name']);
        $rutaDestino = __DIR__ . '/../../vista/imagenes/fotosPerfil/' . $nombreArchivo;
        if (move_uploaded_file($_FILES['avatar']['tmp_name'], $rutaDestino)) {
            $avatar = 'imagenes/fotosPerfil/' . $nombreArchivo; // Ruta relativa desde la vista
        } else {
            $error = "No se pudo subir la imagen.";
        }
    }

  
    if ($usuario['nombre_usuario'] !== $nombre_usuario && !verificarNicknameUnico($nombre_usuario, $id)) {
        $error = "El nickname ya está en uso.";
    }

    if (empty($error)) {
        // Actualizar los datos del usuario
        if (actualizarPerfil($id, $nombre_usuario, $nombre, $apellido, $avatar)) {
            $mensaje = "Perfil actualizado correctamente.";
            $usuario = obtenerDatosUsuario($id); 
        } else {
            $error = "Error al actualizar el perfil.";
        }
    }
}
require_once __DIR__ . '../../../vista/usuaris/editarPerfilesVista.php';
?>
