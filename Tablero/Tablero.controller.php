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

    function insertarCoordenadas()
    {
        $tablero = $this->getBodyJSON();
        $fragatas = $tablero->flota;
        $id_tablero = (int) $tablero->id_tablero;
        for ($i = 0; $i < count($fragatas); $i++) {
            $x = $fragatas[$i]->x;
            $y = $fragatas[$i]->y;
            $this->model->insertarCoordenada($id_tablero, $x, $y);
        }

    }

    function getIdTableroEnemigo($id_juego, $id_tablero)
    {
        $id_tablero_enemigo = null;
        $juego = $this->model->getTableroEnemigo($id_juego);
        if ($juego->id_tablero1 === $id_tablero) {
            $id_tablero_enemigo = $juego->id_tablero2;
        } else {
            $id_tablero_enemigo = $juego->id_tablero1;
        }
        return $id_tablero_enemigo;
    }

    function disparar()
    {
        $json = $this->getBodyJSON();
        $id_juego = $json->id_juego;
        $id_tablero = $json->id_tablero;
        $coordenadas = $json->coordenadas;
        $x = $coordenadas[0];
        $y = $coordenadas[1];
        $objetivoAlcanzado = false;
        $id_tablero_enemigo = $this->getIdTableroEnemigo($id_juego, $id_tablero);
        $coordenadaAlcanzada = $this->model->disparar($id_tablero_enemigo, $x, $y);
        if ($coordenadaAlcanzada !== null) {
            $this->model->actualizarCoordenada($coordenadaAlcanzada->id);
            $objetivoAlcanzado = true;
        }
        echo $objetivoAlcanzado;
    }

    function calcularEstadoDelJuego()
    {
        $json = $this->getBodyJSON();
        $id_juego = $json->id_juego;
        $id_tablero = $json->id_tablero;
        $id_tablero_enemigo = $this->getIdTableroEnemigo($id_juego, $id_tablero);

        $objetivosAlcanzados = $this->model->cantObjetivosAlcanzados($id_tablero_enemigo);
        echo $objetivosAlcanzados;
    }
}


?>