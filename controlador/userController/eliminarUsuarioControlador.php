<?php
session_start();

// Verificar si el usuario ha iniciado sesión y es 'admin'
if (!isset($_SESSION['nombre_usuario']) || $_SESSION['nombre_usuario'] !== 'admin') {
    header("Location: index.php");
    exit();
}


require_once __DIR__.'../../../modelo/user/editarUsuarios.php';

// Verifico si se recibió el ID del usuario
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];


    $usuario = obtenerUsuarioPorId($id);

    if (!$usuario) {
        echo "Usuario no encontrado.";
        exit();
    }


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $accion = $_POST['accion'];

        if ($accion === 'eliminar_todo') {
          
            eliminarArticulosDeUsuario($id);
        } elseif ($accion === 'conservar_articulos') {
           
            $idAnonimo = obtenerIdUsuarioAnonimo();
            if ($idAnonimo === false) {
                echo "No se pudo obtener el ID del usuario anonymous.";
                exit();
            }
            reasignarArticulosAAnonimo($id, $idAnonimo);
        }

      
        $eliminado = eliminarUsuario($id);

        if ($eliminado) {
           
            header("Location: administrarUsuarios.php");
            exit();
        } else {
            $error = "Error al eliminar el usuario.";
        }
    }
} else {
    echo "ID de usuario inválido.";
    exit();
}


require_once __DIR__ . '../../../vista/usuaris/eliminarUsuarioVista.php';
?>
