<?php
// mostrarQR.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$usuario_id = null;

// Verificar si el usuario ha iniciado sesión
if (isset($_SESSION['usuario_id']) && !empty($_SESSION['usuario_id'])) {
    $usuario_id = $_SESSION['usuario_id'];
}

// Incluir la conexión a la base de datos y las funciones necesarias
require_once __DIR__ . '../../../modelo/conexion.php';
require_once __DIR__ . '../../../modelo/articulo/obtenerAnimalPor_Id.php';
require_once __DIR__ . '../../../controlador/articuloController/insertarAnimalQR.php';


$id = 0;
if (isset($_POST['id'])) {
    $id = (int)$_POST['id'];
} elseif (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
}

// Si no tenemos un ID válido, terminamos
if ($id <= 0) {
    die('ID inválido.');
}

// 2) Si es una petición POST, procesamos el formulario
$errores = [];
$correcto = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    list($errores, $correcto) = procesarFormularioQR();
 
}

$animal = obtenerAnimalPor_Id($id);
if (!$animal) {
    die('Animal no encontrado.');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Animal</title>
    <link rel="stylesheet" href="../../estils/estilos_formulario.css">
    <script>
        function confirmarCreacion() {
            return confirm("¿Estás seguro de que deseas copiar este animal?");
        }
    </script>
</head>
<body>
    <!-- 4) Incluimos hidden input con 'id' para conservar su valor al enviar el formulario. -->
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data" onsubmit="return confirmarCreacion();">
    <!-- Campo oculto para usuario_id -->
    <input type="hidden" name="usuario_id" value="<?php echo htmlspecialchars($usuario_id); ?>">
    <input type="hidden" name="id" value="<?php echo $id; ?>">

    <img src="<?php echo htmlspecialchars('../../' . $animal['ruta_imagen']); ?>" width="150" height="100">
    
    <label for="nombre_comun">Nombre Común:</label>
    <input type="text" name="nombre_comun" id="nombre_comun" value="<?php echo htmlspecialchars($animal['nombre_comun']); ?>"><br>

    <label for="nombre_cientifico">Nombre Científico:</label>
    <input type="text" name="nombre_cientifico" id="nombre_cientifico" value="<?php echo htmlspecialchars($animal['nombre_cientifico']); ?>"><br>

    <label for="descripcion">Descripción:</label>
    <textarea name="descripcion" id="descripcion"><?php echo htmlspecialchars($animal['descripcion']); ?></textarea><br>

    <label for="mamifero">Mamífero</label>
    <input type="radio" name="es_mamifero" id="mamifero" value="1" <?php echo ($animal['es_mamifero'] === '1') ? 'checked' : ''; ?>>
    <label for="ovipero">Ovípero</label>
    <input type="radio" name="es_mamifero" id="ovipero" value="0" <?php echo ($animal['es_mamifero'] === '0') ? 'checked' : ''; ?>><br><br>

    <!-- Botón según si el usuario está logueado -->
    <?php
    if ($usuario_id !== null) {
        echo '<button class="iniciarSesion" type="submit">Clic para copiarlo en tu perfil</button>';
    } else  echo "<button class='iniciarSesion' onclick=\"location.href='../../../vista/usuaris/inicioSesion.form.php'\">Inicia sesión para guardar el animal</button>";
   
   
    ?>

    <!-- Botón para volver -->
    <button type="button" onclick="location.href='../../../index.php'">Página principal</button>
    
</form>

<?php
    
    // Mostrar errores si existen
    if (!empty($errores)) {
        echo '<div class="error">';
        foreach ($errores as $error) {
            echo htmlspecialchars($error) . '<br>';
        }
        echo '</div>';
    }
    
    // Mostrar mensaje de éxito si existe
    if (!empty($correcto)) {
        echo '<div class="correcto">' . htmlspecialchars($correcto) . '</div>';
    }
    ?>
</body>
</html>
