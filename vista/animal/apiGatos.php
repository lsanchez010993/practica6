<?php
class CatView
{
    public function renderSelectorLetras()
    {
        // Se agregó 'margin-top: 60px;' al style del form
        echo "<form method='GET' action='' style='display: flex; flex-wrap: wrap; gap: 5px; margin-top: 60px;'>";
     
        echo "<input type='hidden' name='animalesAPI' value='true'>";

        echo "<div style='width: 100%; margin-bottom: 10px;'><label for='letter'>Elige una letra:</label></div>";

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
}
?>
