<?php

require_once('tabla.php');
require_once('Tablero/Tablero.controller.php');

define('BASE_URL', '//' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']) . '/');

if (! empty($_REQUEST['action'])) {
    $action = $_REQUEST['action'];
} else {
    $action = 'tablero';
}

$params = explode('/', $action);

$tableroController = new TableroController();

switch ($params[0]) {
    case 'confirmarTablero':
        $tableroController->confirmarTablero();
        break;
    case 'insertarFlotaEnTablero':
        $tableroController->insertarFlotaEnTablero();
        break;
    default:
        renderizarTabla([-1, "z"]);
        break;
}


?>