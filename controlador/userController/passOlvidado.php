<?php
require_once __DIR__ . '/../../modelo/user/userModel.php';


require_once __DIR__ . '/../../vendor/PHPMailer-master/src/PHPMailer.php';


require_once __DIR__ . '/../../vendor/PHPMailer-master/src/Exception.php';

require_once __DIR__ . '/../../vendor/PHPMailer-master/src/SMTP.php';




use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

function procesarSolicitudRecuperacion($email)
{


    $usuario = obtenerUsuarioPorEmail($email);

    if (!$usuario) {
        return ["No existe ninguna cuenta asociada a este correo electrónico."];
    }

    $token = bin2hex(random_bytes(32));
    $expiracion = date("Y-m-d H:i:s", strtotime('+1 hour'));

    if (guardarTokenRecuperacion($email, $token, $expiracion)) {
        // Enviar el correo electrónico con PHPMailer
        $enlace = "http://luissanchez.cat/vista/usuaris/cambiarContrasenya.php?token=" . urlencode($token);
        // $enlace = "localhost/practicas/practica5/vista/usuaris/cambiarContrasenya.php?token=" . urlencode($token);

        $mail = new PHPMailer(true);

        try {
    
            $mail->isSMTP();
            $mail->Host = 'mailsrv2.dondominio.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'admin@luissanchez.cat'; 
            $mail->Password = '!Q"W12qw'; 
            $mail->SMTPSecure = 'tls'; 
            $mail->Port = 587; 

            // Opciones para deshabilitar la verificación del certificado
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            // Remitente y destinatario
            $mail->setFrom('admin@luissanchez.cat', 'Tu Aplicación');
            $mail->addAddress($email, $usuario['nombre']);

            // Contenido del correo
            $mail->isHTML(true);
            $mail->Subject = 'Recuperación de contraseña';
            $mail->Body    = '
                <p>Hola ' . htmlspecialchars($usuario['nombre']) . ',</p>
                <p>Haz clic en el siguiente enlace para recuperar tu contraseña:</p>
                <p><a href="' . $enlace . '">' . $enlace . '</a></p>
                <p>Si no solicitaste este cambio, puedes ignorar este correo.</p>
                <p>Saludos.</p>
            ';
            $mail->AltBody = 'Hola ' . htmlspecialchars($usuario['nombre']) . ',\n\n'
                . 'Haz clic en el siguiente enlace para recuperar tu contraseña:\n'
                . $enlace . '\n\n'
                . 'Si no solicitaste este cambio, puedes ignorar este correo.\n\n'
                . 'Saludos.';

            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log("No se pudo enviar el correo. Error de PHPMailer: {$mail->ErrorInfo}");
            return ["No se pudo enviar el correo electrónico."];
        }
    }

    return ["Error al procesar la solicitud."];
}

function verificarYCambiarContrasenya($token, $password, $password_confirm) { 

    require_once __DIR__ . '../../../controlador/userController/validarPassword.php';
    $resultadoPassword = comprobarPassword($password, $password_confirm);
    
    if ($resultadoPassword !== true) {
      
        return $resultadoPassword;
    }

    $usuario = verificarToken($token);



    if (!$usuario) {
        return ["El token ha expirado o no es válido."];
    }

    if (cambiarContrasenya($usuario['id'], $password)) {
        return true;
    }

    return ["Error al cambiar la contraseña."];
}

?>
