<?php
require_once __DIR__ .'../../../controlador/articuloController/animalesNoPublicadosController.php';

// var_dump($animalesNoPublicados);



echo '<button type="button" onclick="location.href=\'../../index.php\'">Atrás</button>';


if (!empty($animalesNoPublicados)):
    foreach ($animalesNoPublicados as $animal):
?>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data" onsubmit="return confirmarAprobacion();">

        <img src="<?php echo htmlspecialchars('../' . $animal['ruta_imagen']); ?>" width="150" height="100">

      
        <input type="hidden" name="id" value="<?php echo $animal['id']; ?>">

       
        <label for="nombre_comun_<?php echo $animal['id']; ?>">Nombre Común:</label>
        <input type="text" name="nombre_comun" id="nombre_comun_<?php echo $animal['id']; ?>" value="<?php echo htmlspecialchars($animal['nombre_comun']); ?>"><br>

        
        <label for="nombre_cientifico_<?php echo $animal['id']; ?>">Nombre Científico:</label>
        <input type="text" name="nombre_cientifico" id="nombre_cientifico_<?php echo $animal['id']; ?>" value="<?php echo htmlspecialchars($animal['nombre_cientifico']); ?>"><br>

        
        <label for="descripcion_<?php echo $animal['id']; ?>">Descripción:</label>
        <textarea name="descripcion" id="descripcion_<?php echo $animal['id']; ?>"><?php echo htmlspecialchars($animal['descripcion']); ?></textarea><br>

        
        <label for="mamifero_<?php echo $animal['id']; ?>">Mamífero</label>
        <input type="radio" name="es_mamifero" id="mamifero_<?php echo $animal['id']; ?>" value="1" <?php echo ($animal['es_mamifero'] === '1') ? 'checked' : ''; ?>>
        <label for="ovipero_<?php echo $animal['id']; ?>">Ovípero</label>
        <input type="radio" name="es_mamifero" id="ovipero_<?php echo $animal['id']; ?>" value="0" <?php echo ($animal['es_mamifero'] === '0') ? 'checked' : ''; ?>><br><br>

        
        <input type="submit" value="Aprobar">
    </form>
    <hr>
<?php
    endforeach;
else:
?>
    <p>No hay animales no publicados.</p>
<?php
endif;
?>