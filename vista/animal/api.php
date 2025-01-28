<?php
// Nombre de la raza de gato a buscar
$name = 'abyssinian';

// URL de la API
$api_url = 'https://api.api-ninjas.com/v1/cats?name=' . urlencode($name);

// Tu API Key
$api_key = 'aJslWQDpm187hU2kEFF6Vw==szQPnVbSsE0IPzeD';

// Inicializar cURL
$ch = curl_init();

// Configurar cURL
curl_setopt($ch, CURLOPT_URL, $api_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'X-Api-Key: ' . $api_key
]);

// Ejecutar la solicitud
$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

// Cerrar cURL
curl_close($ch);

// Verificar si la solicitud fue exitosa
if ($http_code === 200) {
    // Decodificar la respuesta JSON
    $data = json_decode($response, true);

    // Mostrar los datos obtenidos
    if (!empty($data)) {
        foreach ($data as $cat) {
          

            echo "<h2>Raza: {$cat['name']}</h2>";
            echo "<p><strong>Origen:</strong> {$cat['origin']}</p>";
            echo "<p><strong>Longitud:</strong> {$cat['length']}</p>";
            echo "<p><strong>Peso:</strong> {$cat['min_weight']} - {$cat['max_weight']} libras</p>";
            echo "<p><strong>Esperanza de vida:</strong> {$cat['min_life_expectancy']} - {$cat['max_life_expectancy']} años</p>";
            echo "<p><img src='{$cat['image_link']}' alt='{$cat['name']}' style='max-width:300px;'></p>";
            echo "<hr>";
        }
    } else {
        echo "No se encontraron datos para la raza especificada.";
    }
} else {
    echo "Error: $http_code - " . $response;
}
?>
