<?php
require_once __DIR__ . '../../../modelo/articulo/apiGatos.php';
require_once __DIR__ . '../../../vista/animal/apiGatos.php';
class CatController
{
    private $model;
    private $view;
    private $data; // Propiedad para almacenar los datos

    public function __construct()
    {
        $this->model = new CatModel();
        $this->view = new CatView();
    }

    public function showCatsByLetter()
    {
        $this->view->renderSelectorLetras();

        if (isset($_GET['letter']) && ctype_alpha($_GET['letter'])) {
            $letter = strtoupper($_GET['letter']);
            $this->data = $this->model->getCatData($letter); // Guardar en propiedad


        } else {
            echo "<p>Elige una letra para comenzar.</p>";
        }
    }
    public function loadDataByLetter($letter)
    {
        // Asumimos que getCatData($letter) retorna un array de datos
        $this->data = $this->model->getCatData($letter);
    }


    public function getData()
    {
        return $this->data;
    }
    public function contarAnimalesAPI()
    {
        return count($this->data);
    }
    public function obtenerAnimalesAPI($start, $articulosPorPagina, $columnaOrden, $direccionOrden)
    {
        try {
            // Obtener los datos desde la API (se asume que getData() retorna un array)
            $data = $this->getData();
            if (!is_array($data)) {
                $data = [];
            }

            // Validar y normalizar la dirección de ordenamiento
            $direccionesPermitidas = ['ASC', 'DESC'];
            $direccionOrden = strtoupper($direccionOrden);
            if (!in_array($direccionOrden, $direccionesPermitidas)) {
                $direccionOrden = 'ASC';
            }

            // Si se indica una columna de ordenamiento, se ordena el array
            if (!empty($columnaOrden)) {
                usort($data, function ($a, $b) use ($columnaOrden, $direccionOrden) {
                    // Si alguno de los elementos no tiene el índice indicado, se considera igual
                    if (!isset($a[$columnaOrden]) || !isset($b[$columnaOrden])) {
                        return 0;
                    }
                    if ($a[$columnaOrden] == $b[$columnaOrden]) {
                        return 0;
                    }
                    if ($direccionOrden === 'ASC') {
                        return ($a[$columnaOrden] < $b[$columnaOrden]) ? -1 : 1;
                    } else { // DESC
                        return ($a[$columnaOrden] > $b[$columnaOrden]) ? -1 : 1;
                    }
                });
            }

            // Realizar la paginación: extraer la porción del array según el offset y la cantidad solicitada
            $paginatedData = array_slice($data, $start, $articulosPorPagina);
            return $paginatedData;
        } catch (\Exception $e) {
            error_log("Error al obtener animales desde API: " . $e->getMessage());
            return [];
        }
    }
}
