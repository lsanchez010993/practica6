<?php
require_once '../../controlador/userController/verificarSesion.php';
require_once '../../controlador/articuloController/insertarAnimalQR_API.php';
require_once '../../controlador/errores/errores.php';

verificarSesion();

// Decodificar los datos del QR desde la URL si existen
$datosAnimal = json_decode($_GET['data'] ?? '', true);

// var_dump($datosAnimal);
// exit();

// Asignar valores, mostrando "Desconocido" si no existen
$nombre_comun = $datosAnimal['name'] ?? 'Desconocido';
$nombre_cientifico = $datosAnimal['scientific_name'] ?? 'Desconocido';
$descripcion = $datosAnimal['description'] ?? 'Desconocido';
$ruta_imagen = $datosAnimal['image_link'] ?? 'ruta_por_defecto.jpg'; // Imagen por defecto si no hay una

$es_mamifero = '1'; // Valor por defecto

// var_dump($datosAnimal['image_link']);
// var_dump($ruta_imagen);

// exit();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    list($errores, $correcto) = procesarFormularioQR();
}


// Si el formulario se ha procesado correctamente, limpiar las variables
if (!empty($correcto)) {
    $nombre_comun = 'Desconocido';
    $nombre_cientifico = 'Desconocido';
    $descripcion = 'Desconocido';
    $ruta_imagen = 'ruta_por_defecto.jpg';
    $es_mamifero = '1';
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Copia Animal</title>
    <link rel="stylesheet" href="../estils/estilos_formulario.css">
    <script>
        function confirmarCreacion() {
            return confirm("¿Estás seguro de que deseas copiar este animal?");
        }
    </script>
</head>

<body>
    <h1>Copiar Animal desde QR</h1>

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data" onsubmit="return confirmarCreacion();">
        <img src="<?php echo htmlspecialchars($ruta_imagen); ?>" width="150" height="100" alt="Imagen del animal">

        <!-- Campo oculto para enviar la ruta de la imagen -->
        <input type="hidden" name="ruta_imagen" value="<?php echo htmlspecialchars($ruta_imagen); ?>">

        <label for="nombre_comun">Nombre Común:</label>
        <input type="text" name="nombre_comun" id="nombre_comun" value="<?php echo htmlspecialchars($nombre_comun); ?>"><br>

        <label for="nombre_cientifico">Nombre Científico:</label>
        <input type="text" name="nombre_cientifico" id="nombre_cientifico" value="<?php echo htmlspecialchars($nombre_cientifico); ?>"><br>

        <label for="descripcion">Descripción:</label>
        <textarea name="descripcion" id="descripcion"><?php echo htmlspecialchars($descripcion); ?></textarea><br>

        <label for="mamifero">Mamífero</label>
        <input type="radio" name="es_mamifero" id="mamifero" value="1" <?php echo $es_mamifero === '1' ? 'checked' : ''; ?>>
        <label for="ovipero">Ovípero</label>
        <input type="radio" name="es_mamifero" id="ovipero" value="0" <?php echo $es_mamifero === '0' ? 'checked' : ''; ?>>

        <button type="submit">Copiar ficha animal</button>
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