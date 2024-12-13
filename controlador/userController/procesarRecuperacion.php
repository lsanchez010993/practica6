<?php
require_once __DIR__ . '/../../modelo/user/userModel.php';
require_once __DIR__ . '/../userController/passOlvidado.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $resultado = procesarSolicitudRecuperacion($email);

    if ($resultado === true) {
        $mensaje = "Correo enviado con instrucciones para recuperar la contraseña.";
    } else {
        $error = is_array($resultado) ? implode('<br>', $resultado) : "Error al procesar la solicitud.";
    }

    include __DIR__ . '../../../vista/usuaris/recuperarContrasenya.php';
}
?>
