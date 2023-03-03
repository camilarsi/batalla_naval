<?php
require_once('Tablero.model.php');

class TableroController
{
    private $model;

    function __construct()
    {
        $this->model = new TableroModel();
    }

    function getBodyJSON()
    {
        $bodyString = file_get_contents("php://input");
        return json_decode($bodyString);
    }

    function confirmarTablero()
    {
        $jugador = file_get_contents("php://input");
        $id_tablero = $this->model->confirmarTablero($jugador);
        echo $id_tablero;
    }

    function insertarFlotaEnTablero()
    {

        $tablero = $this->getBodyJSON();
        $fragatas = $tablero->fragatas;
        $id_tablero = (int) $tablero->id;
        for ($i = 0; $i < count($fragatas); $i++) {
            $x = $fragatas[$i]->x;
            $y = $fragatas[$i]->y;
            $this->model->insertarCoordenada($id_tablero, $x, $y);
        }

    }
}


?>