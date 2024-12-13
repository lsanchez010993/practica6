<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar Usuario</title>
    <link rel="stylesheet" href="../estils/estilos_formulario.css">
</head>
<body>
    <h1>Eliminar Usuario</h1>
    <p>¿Estás seguro de que deseas eliminar al usuario <strong><?php echo htmlspecialchars($usuario['nombre_usuario']); ?></strong>?</p>
    <p>¿Qué quieres hacer con los articulos de ese usuario?:</p>
    <?php if (isset($error)): ?>
        <p class="error"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <form action="" method="post">
        <div class="opcion">
            <input type="radio" name="accion" id="eliminar_todo" value="eliminar_todo" required>
            <label for="eliminar_todo">Eliminar al usuario y todos sus artículos</label>
        </div>
        <div class="opcion">
            <input type="radio" name="accion" id="conservar_articulos" value="conservar_articulos">
            <label for="conservar_articulos">Eliminar al usuario y conservar sus artículos (se reasignarán al usuario anonymous)</label>
        </div>
        <input type="submit" value="Eliminar Usuario" onclick="return confirm('¿Estás seguro de que deseas eliminar este usuario?');">
        <button type="button" onclick="location.href='administrarUsuarios.php'">Atrás</button>
    </form>
</body>
</html>
