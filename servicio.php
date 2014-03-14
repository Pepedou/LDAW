<?php

include_once './Abogado.php';
include_once './Despacho.php';

function procesa(EntidadBD $entidad, $operacion, $params) {
    $entidad->guardarDatos($params);
    switch ($operacion) {
        case 'st':
            $entidad->selectTodos();
            break;
        case 'si':
            $entidad->selectIndividual();
            break;
        case 'in':
            $entidad->insert();
            break;
        case 'up':
            $entidad->update();
            break;
        case 'del':
            $entidad->delete();
            break;
    }
}

$tipo = $_GET['entidad'];
$operacion = $_GET['op'];
$params = $_REQUEST['params'];
$objeto = NULL;

switch ($tipo) {
    case 'Abogado':
        $objeto = new Abogado();
        break;
    case 'Despacho':
        $objeto = new Despacho();
        break;
}

procesa($objeto, $operacion, $params);

//Para el cliente: https://stackoverflow.com/questions/17953468/how-to-pass-a-multidimensional-associative-array-in-url