<?php
require_once '../../controlador/userController/verificarSesion.php';
require_once '../../controlador/articuloController/insertarAnimalController.php';
require_once '../../controlador/errores/errores.php';

verificarSesion();

$nombre_comun = '';
$nombre_cientifico = '';
$descripcion = '';
$es_mamifero = '1'; // Por defecto, 'Mamifero' está seleccionado
$errores = [];
$correcto = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Descomponer el resultado de procesarFormulario() en errores y mensaje de éxito
    list($errores, $correcto) = procesarFormulario();

    // Obtener los valores ingresados en el formulario
    $nombre_comun = $_POST['nombre_comun'];
    $nombre_cientifico = $_POST['nombre_cientifico'];
    $descripcion = $_POST['descripcion'];
    $es_mamifero = $_POST['es_mamifero']; // '1' para Mamifero, '0' para Ovipero
}

// Si el formulario se ha procesado correctamente, limpiar las variables
if (!empty($correcto)) {
    $nombre_comun = '';
    $nombre_cientifico = '';
    $descripcion = '';
    $es_mamifero = '1';
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Nuevo Animal</title>
    <link rel="stylesheet" href="../estils/estilos_formulario.css">
    <script>
        function confirmarCreacion() {
            return confirm("¿Estás seguro de que deseas crear este nuevo animal?");
        }
    </script>
</head>

<body>
    <h1>Nuevo Animal</h1>

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data" onsubmit="return confirmarCreacion();">
        <label for="nombre_comun">Nombre Común:</label>
        <input type="text" name="nombre_comun" id="nombre_comun" value="<?php echo htmlspecialchars($nombre_comun); ?>"><br>

        <label for="nombre_cientifico">Nombre Científico:</label>
        <input type="text" name="nombre_cientifico" id="nombre_cientifico" value="<?php echo htmlspecialchars($nombre_cientifico); ?>"><br>

        <label for="descripcion">Descripción:</label>
        <textarea name="descripcion" id="descripcion"><?php echo htmlspecialchars($descripcion); ?></textarea><br>

        <label for="imagen">Selecciona una imagen:</label>
        <input type="file" name="imagen" id="imagen" accept="image/*"><br><br>

        
        
        <label for="mamifero">Mamífero</label>
        <input type="radio" name="es_mamifero" id="mamifero" value="1" <?php echo $es_mamifero === '1' ? 'checked' : ''; ?>>
        <label for="ovipero">Ovípero</label>
        <input type="radio" name="es_mamifero" id="ovipero" value="0" <?php echo $es_mamifero === '0' ? 'checked' : ''; ?>>
        

        <button type="submit">Crear Animal</button>
        <button type="button" onclick="location.href='../../index.php'">Atrás</button>
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
