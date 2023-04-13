<?php
require_once('ChatGPTConnector.php');
use Dotenv\Dotenv;

class ChatGPTController
{

    private $model;

    function __construct()
    {
        $api_key = $_ENV['API_KEY'];
        $this->model = new ChatGPTConnector($api_key);
    }

    #TODO fijate los nombre cambiar por pedir coordenada
    function insertarFlotaEnemiga()
    {
        $question = "Battleship is a two-player guessing game that is played on a grid of squares. Each player has their own grid, and the grids are usually 10x10, although they can be larger or smaller depending on the version of the game being played.

        The objective of the game is to sink all of your opponent's ships before they sink yours. Each player has a fleet of five ships, which are hidden on their grid. The ships are different sizes, ranging from one square (a \"patrol boat\") to five squares (an \"aircraft carrier\").
        
        Before the game begins, each player places their ships on their grid, horizontally or vertically, but not diagonally. Players cannot place ships next to each other or overlap them. Once all of the ships have been placed, the game begins.
        
        On each turn, a player selects a square on their opponent's grid to attack by calling out a grid reference, such as \"A3\" or \"F7.\" The opponent then responds with either \"hit\" or \"miss,\" depending on whether the square contains part of a ship or not. If the square contains part of a ship, the opponent must also say which ship has been hit (for example, \"hit, you sunk my patrol boat\"). If a ship is hit but not sunk, the player can continue to attack until the ship is sunk.
        
        The game continues in this way until one player has sunk all of their opponent's ships. The player who sinks all of their opponent's ships first is the winner.
        
        To summarize, here are the rules of Battleship:
        
        The game is played on a grid of squares.
        Each player has a fleet of five ships, which are hidden on their grid.
        Players take turns selecting a square on their opponent's grid to attack.
        The opponent responds with either \"hit\" or \"miss.\"
        If the square contains part of a ship, the opponent must also say which ship has been hit.
        The game continues until one player has sunk all of their opponent's ships.
        
        Act as a rival player of battleship who generates one coordinate per message with table received as input, returning ONLY the coordinate in JSON format, DO NOT EXPLAIN the process, and return nothing else besides the coordinate in JSON format like so: `[1, 'a']`
        In a 10x10 board, a valid coordinate would be [5, 'h'].
        In each message sent to you, you must evaluate the received board and respond ONLY with the coordinate of your play. The pattern with which you choose the coordinate parameters must take as input the board sent to you in each message.
        An example board is as follows:
        ```
        [[\"\", \"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"],
        [\"\", \"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"],
        [\"\", \"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"],
        [\"\", \"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"],
        [\"\", \"HIT\",\"HIT\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"],
        [\"\", \"MISS\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"],
        [\"\", \"\",\"\",\"\",\"\",\"MISS\",\"\",\"\",\"\",\"\"],
        [\"\", \"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"],
        [\"\", \"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"],
        [\"\", \"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"]
        ]
        ```
        The board is an array of arrays where the columns are numbers and the rows are letters. The valid columns are from 1 to 10 and from a to j.
        \"HIT\", \"MISS\" or \"SUNK\" correspond to the coordinates that have already been played, and are therefore invalid coordinates for you.
        Starting now, generate a new coordinate, since you play first.";
        $text = $this->model->askQuestion($question);
        echo $text;
    }


}

?>