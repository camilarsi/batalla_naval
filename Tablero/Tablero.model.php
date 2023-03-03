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
        $id_barco = uniqid();
        $sentencia = $this->db->prepare("INSERT INTO coordenada(id_barco, id_tablero,x,y) VALUES(?, ?, ?, ?)");
        $sentencia->execute(array($id_barco, $id_tablero, $x, $y));
        return $this->db->lastInsertId();
    }

}

?>