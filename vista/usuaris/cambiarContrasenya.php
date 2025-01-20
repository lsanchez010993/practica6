<?php

// Asignar el token
$token = trim($_GET['token'] ?? '');

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Cambiar Contraseña</title>
    <link rel="stylesheet" href="../estils/estilos_formulario.css">
    <link rel="stylesheet" href="../../vista/estils/estilos_formulario.css">

</head>

<body>
    <h1>Cambiar Contraseña</h1>
    <?php if (isset($error)) {
        echo "<p class='error'>$error</p>";
    } ?>
    <?php if (isset($mensaje)) {
        echo "<p class='correcto'>$mensaje</p>";
    } ?>
    <form class="formulario" action="../../controlador/userController/procesarCambioContrasenya.php" method="POST">
        <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
        <label for="password">Nueva Contraseña:</label>
        <input type="password" name="password" id="password">
        <label for="password_confirm">Confirmar Contraseña:</label>
        <input type="password" name="password_confirm" id="password_confirm">
        <button type="submit">Cambiar Contraseña</button>
        <button type="button" class="btn" onclick="location.href='/vista/usuaris/iniciarSesion.form.php'">Iniciar sesión</button>
    </form>
   
</body>

</html>
