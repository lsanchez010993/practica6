<?php
session_start();


if (!isset($_SESSION['nombre_usuario']) || $_SESSION['nombre_usuario'] !== 'admin') {
    header("Location: login.php");
    exit();
}

require_once __DIR__.'../../../modelo/user/editarUsuarios.php';


if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];


    $usuario = obtenerUsuarioPorId($id);

    if (!$usuario) {
        echo "Usuario no encontrado.";
        exit();
    }

    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre_usuario = trim($_POST['nombre_usuario']);
        $email = trim($_POST['email']);

       
        if (empty($nombre_usuario) || empty($email)) {
            $error = "Todos los campos son obligatorios.";
        } else {
            // Actualizar el usuario en la base de datos
            $actualizado = actualizarUsuario($id, $nombre_usuario, $email);

            if ($actualizado) {
               
                header("Location: administrarUsuarios.php");
                exit();
            } else {
                $error = "Error al actualizar el usuario.";
            }
        }
    }
} else {
    echo "ID de usuario inválido.";
    exit();
}


require_once __DIR__ . '../../../vista/usuaris/editarUsuarioVista.php';
?>
