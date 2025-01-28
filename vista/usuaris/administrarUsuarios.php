<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="../estils/administrarUsuarios.css">
    <link rel="stylesheet" href="../../vista/estils/administrarUsuarios.css">
</head>

<body>
    <h1>Lista de Usuarios</h1>
    
    <!-- Contenedor para la tabla y el botón -->
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre de Usuario</th>
                    <th>Email</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($usuarios && count($usuarios) > 0): ?>
                    <?php foreach ($usuarios as $usuario): ?>
                        <tr>
                            <?php if ($usuario['nombre_usuario'] == 'admin') continue; ?>
                            <td><?php echo htmlspecialchars($usuario['id']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['nombre_usuario']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['email']); ?></td>
                            <td>
                                <a href="../../controlador/userController/editarUsuarioController.php?id=<?php echo $usuario['id']; ?>">Editar</a> |
                                <a href="../../controlador/userController/eliminarUsuarioControlador.php?id=<?php echo $usuario['id']; ?>">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">No hay usuarios registrados.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        
        <!-- Botón "Atrás" dentro del mismo contenedor -->
        <button class="atras" type="button" onclick="location.href='../../index.php'">Atrás</button>
    </div>
</body>
</html>
