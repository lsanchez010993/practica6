<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim(strtolower($_POST['nombre_usuario']));
}

function verUsuarios()
{
    try {
        require_once '../../modelo/conexion.php';

        $pdo = connectarBD();

        // Consulta para obtener todos los usuarios
        $sql = "SELECT id, nombre_usuario, email FROM usuarios";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resultados;
    } catch (PDOException $e) {
       
        error_log("Error al obtener los usuarios: " . $e->getMessage());
        return false; // Devuelve false en caso de error
    }
}


function obtenerUsuarioPorId($id)
{
    try {
        require_once '../../modelo/conexion.php';

        $pdo = connectarBD();

        // Consulta para obtener el usuario por ID
        $sql = "SELECT id, nombre_usuario, email FROM usuarios WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        return $usuario;
    } catch (PDOException $e) {
        error_log("Error al obtener el usuario: " . $e->getMessage());
        return false;
    }
}

function actualizarUsuario($id, $nombre_usuario, $email)
{
    try {
        require_once '../../modelo/conexion.php';

        $pdo = connectarBD();

        // Consulta para actualizar el usuario
        $sql = "UPDATE usuarios SET nombre_usuario = :nombre_usuario, email = :email WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nombre_usuario', $nombre_usuario);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        error_log("Error al actualizar el usuario: " . $e->getMessage());
        return false;
    }
}

function eliminarUsuario($id)
{
    try {
        require_once '../../modelo/conexion.php';
        $pdo = connectarBD();

        // Eliminar el usuario de la tabla usuarios
        $sql = "DELETE FROM usuarios WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return true;
    } catch (PDOException $e) {
        error_log("Error al eliminar el usuario: " . $e->getMessage());
        return false;
    }
}

function eliminarArticulosDeUsuario($id)
{
    try {
        require_once '../../modelo/conexion.php';
        $pdo = connectarBD();

        // Eliminar los artículos del usuario
        $sql = "DELETE FROM animales WHERE usuario_id = :usuario_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':usuario_id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return true;
    } catch (PDOException $e) {
        error_log("Error al eliminar los artículos del usuario: " . $e->getMessage());
        return false;
    }
}

function reasignarArticulosAAnonimo($idUsuarioActual, $idUsuarioAnonimo)
{
    try {
        require_once '../../modelo/conexion.php';
        $pdo = connectarBD();

        // Actualizar los artículos para que pertenezcan al usuario anonymous
        $sql = "UPDATE animales SET usuario_id = :id_anonymous WHERE usuario_id = :id_usuario";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_anonymous', $idUsuarioAnonimo, PDO::PARAM_INT);
        $stmt->bindParam(':id_usuario', $idUsuarioActual, PDO::PARAM_INT);
        $stmt->execute();

        return true;
    } catch (PDOException $e) {
        error_log("Error al reasignar los artículos al usuario anonymous: " . $e->getMessage());
        return false;
    }
}

function obtenerIdUsuarioAnonimo()
{
    try {
        require_once '../../modelo/conexion.php';
        $pdo = connectarBD();

        // Obtener el ID del usuario anonymous
        $sql = "SELECT id FROM usuarios WHERE nombre_usuario = 'anonymous'";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $id = $stmt->fetchColumn();
        return $id;
    } catch (PDOException $e) {
        error_log("Error al obtener el ID del usuario anonymous: " . $e->getMessage());
        return false;
    }
}

function obtenerDatosUsuario($id)
{
    try {
        require_once '../../modelo/conexion.php';
        $pdo = connectarBD();

        $sql = "SELECT id, nombre_usuario, nombre, apellido, email, avatar FROM usuarios WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        return $usuario;
    } catch (PDOException $e) {
        error_log("Error al obtener los datos del usuario: " . $e->getMessage());
        return false;
    }
}

function verificarNicknameUnico($nickname, $idActual = null)
{
    try {
        require_once '../../modelo/conexion.php';
        $pdo = connectarBD();

        $sql = "SELECT COUNT(*) FROM usuarios WHERE nombre_usuario = :nickname";
        if ($idActual !== null) {
            $sql .= " AND id != :id";
        }
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nickname', $nickname, PDO::PARAM_STR);
        if ($idActual !== null) {
            $stmt->bindParam(':id', $idActual, PDO::PARAM_INT);
        }
        $stmt->execute();
        return $stmt->fetchColumn() == 0;
    } catch (PDOException $e) {
        error_log("Error al verificar el nickname: " . $e->getMessage());
        return false;
    }
}

function actualizarPerfil($id, $nombre_usuario, $nombre, $apellido, $avatar)
{
    try {
        require_once '../../modelo/conexion.php';
        $pdo = connectarBD();

        $sql = "UPDATE usuarios SET nombre_usuario = :nombre_usuario, nombre = :nombre, apellido = :apellido, avatar = :avatar WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nombre_usuario', $nombre_usuario);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido', $apellido);
        $stmt->bindParam(':avatar', $avatar);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        error_log("Error al actualizar el perfil: " . $e->getMessage());
        return false;
    }
}
?>
