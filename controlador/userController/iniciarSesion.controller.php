<?php
function iniciarSesionController($nombre_usuario, $password)
{
    $errores = [];
    session_start();

    // Inicializa intentos de inicio de sesión
    if (!isset($_SESSION['login_attempts'])) {
        $_SESSION['login_attempts'] = 0;
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        // Si el número de intentos es 3 o más, validar reCAPTCHA
        if ($_SESSION['login_attempts'] >= 3) {
            if (!isset($_POST['g-recaptcha-response']) || empty($_POST['g-recaptcha-response'])) {
                $errores[] = 'Por favor, completa el reCAPTCHA.';
                return $errores;
            } else {
                $recaptcha_secret = '6LdQLocqAAAAAHFW4ZpczXoarU5AE5JoR5mfnJPd';
                $recaptcha_response = $_POST['g-recaptcha-response'];
                $recaptcha = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$recaptcha_secret&response=$recaptcha_response");
                $recaptcha = json_decode($recaptcha);

                if (!$recaptcha->success) {
                    $errores[] = 'La verificación de reCAPTCHA ha fallado. Inténtalo de nuevo.';
                    return $errores;
                }
            }
        }

        // Validación de la contraseña
        require_once "validarPassword.php";
        $password_ok = comprobarPassword($password);


        if ($password_ok == true) {
            require_once "../../modelo/user/iniciarSesion.php";
            $usuario = iniciarSesion($nombre_usuario);
            $_SESSION['nombre_usuario'] = $nombre_usuario;
            if (verificarPassword_BD($usuario, $password, $nombre_usuario)) {

                $errores = '';
            } else {
                $errores = [ErroresInicioSesion::ERROR_INICIO_SESION];
            }


            if (empty($errores)) {

              
                $_SESSION['login_attempts'] = 0;

                // Verificar si el usuario seleccionó "Recordar"
                if (isset($_POST['recordar']) && $_POST['recordar'] === 'on') {
                    // Generar un token seguro
                    $token = bin2hex(random_bytes(32)); 

                    require_once "../../modelo/user/tokenInicioSesion.php";
                    almacenarTokenEnBD($nombre_usuario, $token); // Almacenar token en la base de datos


                    // Guardar el token y el nombre de usuario en cookies
                    setcookie('token', $token, time() + (30 * 24 * 60 * 60), "/"); // 30 días
                    setcookie('nombre_usuario', $nombre_usuario, time() + (30 * 24 * 60 * 60), "/");

                    header("Location: ../../index.php");
                    exit();
                }else{
                    header("Location: ../../index.php");
                    exit();
                }

                
            } else {
                $errores[] = 'Credenciales inválidas.';
                $_SESSION['login_attempts']++; 
            }
        } else {
            $errores[] = ErroresPassword::CONTRASEÑA_INCORRECTA;
            $_SESSION['login_attempts']++; 
        }
    }

    return $errores;
}
