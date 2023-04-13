<?php
require 'vendor/autoload.php';
require_once('tabla.php');
require_once('Tablero/Tablero.controller.php');
require_once('ChatGPT/ChatGPT.controller.php');
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();


define('BASE_URL', '//' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']) . '/');

if (! empty($_REQUEST['action'])) {
    $action = $_REQUEST['action'];
} else {
    $action = 'tablero';
}

$params = explode('/', $action);

$tableroController = new TableroController();
$chatGPTController = new ChatGPTController();

switch ($params[0]) {
    case 'confirmarTablero':
        $tableroController->confirmarTablero();
        break;
    case 'insertarFlotaEnTablero':
        $tableroController->insertarCoordenadas();
        $chatGPTController->insertarFlotaEnemiga();
        break;
    case 'disparar':
        $tableroController->disparar();
    case 'estado':
        $tableroController->calcularEstadoDelJuego();
    default:
        renderizarTabla([-1, "z"]);
        break;
}


?>