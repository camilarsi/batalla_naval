<?php

class TableroModel
{

    private $db;
    function __construct()
    {
        $this->db = new PDO('mysql:host=localhost;' . 'dbname=batalla_naval;charset=utf8', 'root', '');
    }

    function confirmarTablero($jugador)
    {
        $sentencia = $this->db->prepare("INSERT INTO tablero(jugador) VALUES(?) ");
        $sentencia->execute(array($jugador));
        return $this->db->lastInsertId();
    }


    function insertarCoordenada($id_tablero, $x, $y)
    {
        $sentencia = $this->db->prepare("INSERT INTO coordenada(id_tablero,x,y) VALUES(?, ?, ?)");
        $sentencia->execute(array($id_tablero, $x, $y));
        return $this->db->lastInsertId();
    }

    function getTableroEnemigo($id_juego)
    {
        $sentencia = $this->db->prepare("SELECT * FROM juego  WHERE id=?");
        $sentencia->execute(array($id_juego));
        $respuesta = $sentencia->fetch(PDO::FETCH_OBJ);
        return $respuesta;

    }

    function disparar($id_tablero_enemigo, $x, $y)
    {
        $sentencia = $this->db->prepare("SELECT * FROM coordenadas WHERE id_tablero=? AND x= ? AND y=?");
        $sentencia->execute(array($id_tablero_enemigo, $x, $y));
        $respuesta = $sentencia->fetch(PDO::FETCH_OBJ);
        return $respuesta;
    }

    function actualizarCoordenada($id_coordenadaAlcanzada)
    {
        $sentencia = $this->db->prepare("UPDATE coordenadas SET alcanzada = ? WHERE id = ?");
        $sentencia->execute(array(true, $id_coordenadaAlcanzada));
    }

    function cantObjetivosAlcanzados($id_tablero_enemigo)
    {
        $sentencia = $this->db->prepare("SELECT COUNT(*) FROM coordenadas WHERE id=? AND alcanzada=?");
        $respuesta = $sentencia->execute(array($id_tablero_enemigo, true));
        return $respuesta;

    }

}

?>