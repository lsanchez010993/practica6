<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Recuperar Contraseña</title>
    <link rel="stylesheet" href="../../vista/estils/estilos_formulario.css">
</head>

<body>
    <h1>Recuperar Contraseña</h1>

    <form action="../../controlador/userController/procesarRecuperacion.php" method="POST">
        <label for="email">Introduce tu correo electrónico:</label>
        <input type="email" name="email" id="email" required>
        <button type="submit">Enviar</button>
        <button type="button" onclick="location.href='../../index.php'">Volver a inicio</button>
        <?php if (isset($error)) {
            echo "<p style='color:red;'>$error</p>";
        } ?>
        <?php if (isset($mensaje)) {
            echo "<p style='color:green;'>$mensaje</p>";
        } ?>
    </form>
</body>

</html>