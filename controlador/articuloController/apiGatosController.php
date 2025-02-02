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

            // $this->view->generarGatos($this->data);
        } else {
            echo "<p>Elige una letra para comenzar.</p>";
        }
    }

    // Método para obtener los datos fuera de la función
    public function getData()
    {
        return $this->data;
    }
}

?>
