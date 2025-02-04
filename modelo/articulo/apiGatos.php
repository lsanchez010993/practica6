<?php
class CatModel
{
    private $api_key = 'aJslWQDpm187hU2kEFF6Vw==szQPnVbSsE0IPzeD';
    private $api_url = 'https://api.api-ninjas.com/v1/cats';

     public function mostrarGatosPorLetra($letter = '')
    {
        // Si no se especifica una letra, se define un valor predeterminado (por ejemplo, 'A')
        if (empty($letter)) {
            $letter = 'A';
        }

        // Obtienes todos los datos de la API
        $data = $this->getCatData();

        // Filtras los datos para quedarte solo con los gatos cuyo nombre empieza por la letra indicada
        $filteredData = array_filter($data, function($cat) use ($letter) {
            // Se compara en mayúsculas para evitar problemas de mayúsculas/minúsculas
            return strtoupper(substr($cat['name'], 0, 1)) === strtoupper($letter);
        });

        // Ahora, puedes pasar $filteredData a la vista o procesarlo como necesites.
        // Por ejemplo:
        require 'views/cats_view.php';
    }

    // Ejemplo de la función getCatData (puede variar según tu implementación)
    public function getCatData($name = '')
    {
        if (empty($name)) {
            $name = 'a'; // Valor predeterminado si no se pasa ninguna letra
        }

        $url = $this->api_url . '?name=' . urlencode($name);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'X-Api-Key: ' . $this->api_key
        ]);

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($http_code === 200) {
            return json_decode($response, true);
        } else {
            return [
                'error'   => true,
                'code'    => $http_code,
                'message' => $response
            ];
        }
    }
}
?>
