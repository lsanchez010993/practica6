<?php
class CatModel
{
    private $api_key = 'aJslWQDpm187hU2kEFF6Vw==szQPnVbSsE0IPzeD';
    private $api_url = 'https://api.api-ninjas.com/v1/cats';

    public function getCatData($name = '')
    {
        if (empty($name)) {
            $name = 'a'; // Valor predeterminado
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
                'error' => true,
                'code' => $http_code,
                'message' => $response
            ];
        }
    }

}
?>
