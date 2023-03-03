<?php

function renderizarTabla($params)
{
    $y = "a";
    echo "<table>";
    for ($row = 0; $row <= 9; $row++) {
        echo "<tr>";
        for ($col = 0; $col <= 9; $col++) {
            if ($row == 0) {
                echo '<td class="coordenada-numerica">' . $col . '</td>';
            } else if ($col == 0) {
                echo '<td class="coordenada-alfabetica">' . $y . '</td>';
            } else if ($col == $params[0] && $y == $params[1]) {
                $coordenadas = array(
                    'x' => $col,
                    'y' => $y
                );
                // generar elemento td con propiedad dataset
                echo '<td class="seleccionada" data-coordenadas="' . htmlentities(json_encode($coordenadas)) . '"></td>';
            } else {
                // crear objeto con dos propiedades coordenadas
                $coordenadas = array(
                    'x' => $col,
                    'y' => $y
                );
                // generar elemento td con propiedad dataset
                echo '<td class="seleccionable" data-coordenadas="' . htmlentities(json_encode($coordenadas)) . '"></td>';
            }
        }
        echo "</tr>";
        if ($row != 0) {
            $y++;
        }
    }
    echo "</table>";
}



?>