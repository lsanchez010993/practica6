<?php
session_start();

if (!isset($_SESSION['nombre_usuario'])) {
    header('Location: login.php'); // Redirige al login si no hay sesión
    exit();
}

$passActual = $PassNuevo = $confirmPassword = '';
$errores = [];
$correcto = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $passActual = $_POST['pass_Actual'];
    $PassNuevo = $_POST['Pass_Nuevo'];
    $confirmPassword = $_POST['confirm_password'];
    $nombre_user = $_SESSION['nombre_usuario'];

   
    require_once '../../controlador/userController/cambiarPass.controller.php';
    $esCorrecto = verificarPasswordCorrecto_Controller($nombre_user, $passActual);

    if ($esCorrecto) {
        // Validar la nueva contraseña
        require_once '../../controlador/userController/validarPassword.php';
        $resultadoComprobacion = comprobarPassword($PassNuevo, $confirmPassword);

        if ($resultadoComprobacion === true) {
            // No hay errores, actualizar la contraseña
            $resultado = actualizarPassword_Controller($nombre_user, $PassNuevo);

            if ($resultado) {
                $correcto = "Password actualizado correctamente.";
            } else {
                $errores[] = "Error al actualizar el password.";
            }
        } else {
            
            $errores = $resultadoComprobacion;
        }
    } else {
        $errores[] = "La contraseña actual es incorrecta.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar Password</title>
    <link rel="stylesheet" href="../estils/cambiarPass.css">
</head>
<body>
<div class="form-container">
    <h2>Cambiar Password</h2>
    <p>Introduce tu contraseña actual y luego la nueva contraseña</p>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
        <label for="pass_Actual">Password actual</label>
        <input type="password" id="pass_Actual" name="pass_Actual" required><br>

        <label for="Pass_Nuevo">Nuevo Password</label>
        <input type="password" id="Pass_Nuevo" name="Pass_Nuevo" required><br>

        <label for="confirm-password">Confirmar Password</label>
        <input type="password" id="confirm-password" name="confirm_password" required><br>

        <button type="submit">Cambiar Password</button><br>
        <button type="button" onclick="location.href='../../index.php'">Atrás</button>
    </form>
    
    <?php
    // Mostrar los errores si existen
    if (!empty($errores)) {
        echo '<div class="error-messages">';
        foreach ($errores as $error) {
            echo '<p class="error">' . htmlspecialchars($error) . '</p>';
        }
        echo '</div>';
    }

    // Mostrar mensaje de éxito si la contraseña se ha actualizado correctamente
    if (!empty($correcto)) {
        echo '<p class="correcto">' . htmlspecialchars($correcto) . '</p>';
    }
    ?>
</div>
</body>
</html>
