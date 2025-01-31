<?php
require_once __DIR__ . '../../../modelo/articulo/apiGatos.php';
require_once __DIR__ . '../../../vista/animal/apiGatos.php';
class CatController
{
    private $model;
    private $view;

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
            $data = $this->model->getCatData($letter);
            $this->view->generarGatos($data);
        } else {
            echo "<p>Elige una letra para comenzar.</p>";
        }
    }
}
?>
