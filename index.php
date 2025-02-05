<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION['nombre_usuario'])) {
    require_once __DIR__ . '/modelo/user/tokenInicioSesion.php';
    verificarTokenSesion(); // Verifica el token si no hay sesión iniciada
}


$session_iniciada = isset($_SESSION['nombre_usuario']);
$nombre = $session_iniciada ? $_SESSION['nombre_usuario'] : null;


$administrar = false;

// Verificar si el usuario es administrador
if ($session_iniciada && $nombre === 'admin') {
    $administrar = isset($_GET['administrar']) && $_GET['administrar'] === 'true';
}

// $todosAnimales = isset($_GET['todosAnimales']) && $_GET['todosAnimales'] === '';
$todosAnimales = isset($_GET['todosAnimales']) ? htmlspecialchars($_GET['todosAnimales']) : '';
$animalesAPI = isset($_GET['animalesAPI']) ? htmlspecialchars($_GET['animalesAPI']) : '';



?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Principal</title>
    <link rel="stylesheet" href="vista/estils/header.menu.css">

    <base href="./">

</head>

<body>

    <!-- Banner en la parte superior -->
    <header class="banner">

        <?php if ($session_iniciada): ?>



            <?php if ($administrar): ?>
                <?php $_SESSION['administrar'] = $administrar; ?>
                <!-- Panel de Administración -->
                <span class="panel_administrador">Panel de administración:</span>
             
            <?php else: ?>
                <!-- Mensaje de Bienvenida (no administración) -->
                <div class="submenu">
                    <span class="nombre_usuario">Bienvenido: <?php echo htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8'); ?></span>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <!-- Barra de búsqueda -->
         <?php if (!$animalesAPI): ?>
        <div>
            <form class="search-bar" action="" method="GET" onsubmit="return false;">
                <input type="text" name="nombre_comun" placeholder="Buscar animal..." autocomplete="on">
            </form>

        </div>
        <?php endif; ?>
        <div class="menu menu-right">
            <?php if (!isset($resultadosBusqueda)): ?>
                <!-- Menú principal -->
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
                            <!-- Submenú de administración (si el usua
                             rio es admin) -->
                            <div class="submenu">
                                <button class="submenu-toggle">Administrar</button>
                                <div class="submenu-content">
                                    <button onclick="location.href='controlador/userController/administrarUsuarios.php'">Administrar Usuarios</button>
                                    <button onclick="location.href='index.php?administrar=true'">Administrar Animales</button>
                                </div>
                                <button onclick="location.href='vista/animal/animalesNoPublicados.php'">Aprobar animales</button>
                            </div>
                        <?php endif; ?>

                        <!-- Opciones si la sesión está iniciada (no admin o admin tras su menú) -->
                        <button onclick="location.href='vista/animal/insertarNuevoAnimal.php'">Insertar Nuevo Artículo</button>
                        <button onclick="location.href='controlador/userController/editarPerfilesUser.php'">Editar Perfil</button>
                        <button onclick="location.href='modelo/user/cerrarSesion.php'">Cerrar Sesión</button>
                        <button onclick="location.href='vista/usuaris/cambiarPass.php'">Cambiar Password</button>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>

    </header>


    <main>

        <div id="resultat" class="resultados"></div>
        <?php



        include_once 'vista/animal/vistaAnimales.php'

        ?>

    </main>


</body>

</html>