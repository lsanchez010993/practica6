<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Obtener la URL solicitada

// Despachar la URL al controlador correspondiente

if (!isset($_SESSION['nombre_usuario'])) {
    require_once __DIR__ . '/modelo/user/tokenInicioSesion.php';
    verificarTokenSesion(); // Verifica el token si no hay sesión iniciada
}

// Establecemos la variable para verificar si la sesión está iniciada
$session_iniciada = isset($_SESSION['nombre_usuario']);
$nombre = $session_iniciada ? $_SESSION['nombre_usuario'] : null;

$administrar = false;

// Verificar si el usuario es administrador
if ($session_iniciada && $nombre === 'admin') {
    $administrar = isset($_GET['administrar']) && $_GET['administrar'] === 'true';
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Principal</title>
    <link rel="stylesheet" href="vista/estils/header.menu.css">
    <link rel="stylesheet" href="../../vista/estils/header.menu.css">
</head>

<body>

    <!-- Banner en la parte superior -->
    <header class="banner">
        <?php if ($session_iniciada): ?>
            <?php if ($administrar): ?>

                <?php $_SESSION['administrar'] = $administrar; ?>

                <!-- Mostrar solo el panel de administración -->
                <span class="nombre_usuario">Panel de administración: </span>
                <button onclick="location.href='controlador/userController/eliminarNombreSession.php?variable=nombre_variable'">Atrás</button>
            <?php else: ?>
                <div class="submenu">
                    <!-- Mostrar el mensaje de bienvenida si no está en modo administración -->
                    <span class="nombre_usuario">Bienvenido: <?php echo htmlspecialchars($nombre); ?></span>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <!-- Barra de búsqueda -->
        <div>
            <?php
            if (!isset($resultadosBusqueda)) {
                $rutaBuscarPorNombre = 'controlador/articuloController/buscarPorNombre.php';
            } else {
                $rutaBuscarPorNombre = '../../controlador/articuloController/buscarPorNombre.php';
            }
            ?>
            <form class="search-bar" action="<?php echo $rutaBuscarPorNombre; ?>" method="GET">
                <input type="text" name="nombre_comun" placeholder="Buscar..." required>
                <button type="submit">Buscar Animal</button>
            </form>
        </div>

        <div class="menu menu-right">

            <?php if (!isset($resultadosBusqueda)) { ?>
                <button class="menu-toggle">
                    <?php echo $session_iniciada ? 'Menú' : 'No has iniciado sesión'; ?>
                </button>
                <div class="menu-content">
                    <?php if (!$session_iniciada): ?>
                        <!-- Opciones si la sesión no está iniciada -->
                        <button onclick="location.href='vista/usuaris/inicioSesion.form.php'">Iniciar Sesión</button>
                        <button onclick="location.href='vista/usuaris/crearUsuario.php'">Registrarse</button>
                        <button onclick="location.href='vista/usuaris/recuperarContrasenya.php'">Recuperar Contraseña</button>

                    <?php else: ?>
                        <?php if ($nombre === 'admin'): ?>
                            <!-- Submenú para Administrar -->
                            <div class="submenu">
                                <button class="submenu-toggle">Administrar</button>
                                <div class="submenu-content">
                                    <button onclick="location.href='controlador/userController/administrarUsuarios.php'">Administrar Usuarios</button>
                                    <button onclick="location.href='index.php?administrar=true'">Administrar Animales</button>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Opciones si la sesión está iniciada -->
                        <button onclick="location.href='vista/animal/insertarNuevoAnimal.php'">Insertar Nuevo Artículo</button>
                        <button onclick="location.href='controlador/userController/editarPerfilesUser.php'">Editar Perfil</button>
                        <button onclick="location.href='modelo/user/cerrarSesion.php'">Cerrar Sesión</button>
                        <button onclick="location.href='vista/usuaris/cambiarPass.php'">Cambiar Password</button>
                    <?php endif; ?>
                </div>
            <?php } else { ?>
                <button onclick="location.href='../../index.php'">Atrás</button>
            <?php } ?>
        </div>
    </header>

    <main>
        <?php include_once 'vista/animal/vistaAnimales.php'; ?>
    </main>

</body>

</html>