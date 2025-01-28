<?php
// URL del endpoint para todos los animales
$url = 'https://zoo-animal-api.herokuapp.com/animals';

// Obtener los datos de la API
$response = file_get_contents($url);
$data = json_decode($response, true);

// Verificar si se recibieron datos
if ($data) {
    echo "<h1>Lista de Animales</h1>";
    foreach ($data as $animal) {
        echo "<h2>Nombre: {$animal['name']}</h2>";
        echo "<p><strong>Nombre científico:</strong> {$animal['latin_name']}</p>";
        echo "<p><strong>Tipo:</strong> {$animal['animal_type']}</p>";
        echo "<p><strong>Hábitat:</strong> {$animal['habitat']}</p>";
        echo "<p><strong>Dieta:</strong> {$animal['diet']}</p>";
        echo "<img src='{$animal['image_link']}' alt='Imagen de {$animal['name']}' style='width:200px;' />";
        echo "<hr>";
    }
} else {
    echo "Error al obtener datos de la API.";
}
?>
