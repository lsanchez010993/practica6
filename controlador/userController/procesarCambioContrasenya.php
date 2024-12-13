<?php



require_once __DIR__ . '/../../modelo/user/userModel.php';
require_once __DIR__ . '/../userController/passOlvidado.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = trim($_POST['token'] ?? '');
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';

    $resultado = verificarYCambiarContrasenya($token, $password, $password_confirm);

    if ($resultado === true) {
        $mensaje = "Contraseña actualizada correctamente.";
    } else {
        $error = is_array($resultado) ? implode('<br>', $resultado) : "Error al cambiar la contraseña.";
    }

    include __DIR__ . '/../../vista/usuaris/cambiarContrasenya.php';
}
?>
