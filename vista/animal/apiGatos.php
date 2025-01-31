<?php
class CatView
{
    public function renderSelectorLetras()
    {
        echo "<form method='GET' action='' style='display: flex; flex-wrap: wrap; gap: 5px;'>";
     
        echo "<input type='hidden' name='animalesAPI' value='true'>";

        echo "<label for='letter' style='margin-right: 10px;'>Elige una letra:</label>";

        foreach (range('A', 'Z') as $letter) {
            $isSelected = (isset($_GET['letter']) && strtoupper($_GET['letter']) === $letter);
            $style = $isSelected
                ? "background-color: #007BFF; color: white;"
                : "background-color: #f0f0f0; color: black;";
            echo "<button type='submit' name='letter' value='$letter' style='padding: 10px 15px; border: none; border-radius: 5px; $style'>$letter</button>";
        }

        echo "</form>";
        echo "<hr>";
    }



    public function generarGatos($data)
    {
        if (!empty($data)) {
            echo "<div class='contenedor-tarjetas'>";
            foreach ($data as $gato) {
                echo "<div class='tarjeta'>";
    
                echo "<h2><strong>Nombre común: </strong>" . htmlspecialchars($gato['name']) . "</h2>";
                echo "<h3><span>Nombre científico: </span>" . htmlspecialchars($gato['scientific_name'] ?? 'No disponible') . "</h3>";
                echo "<p><strong>Mamífero: </strong>" . htmlspecialchars((isset($gato['is_mammal']) && $gato['is_mammal'] == 1) ? 'Sí' : 'No') . "</p>";
    
                if (!empty($gato['image_link'])) {
                    echo "<img src='" . htmlspecialchars($gato['image_link']) . "' alt='Imagen del gato' class='tarjeta-imagen'>";
                }
    
                echo "<p class='descripcion'>" . htmlspecialchars($gato['description'] ?? 'Sin descripción') . "</p>";
    
                echo "<hr>";
                echo "</div>"; 
            }
            echo "</div>"; 
        } else {
            echo "<p>No se encontraron datos para la letra seleccionada.</p>";
        }
    }
    
}
