<?php

include_once './Clases/EntidadFactory.php';

$tipo = $_GET['entidad'];
$operacion = $_GET['op'];
$params = $_REQUEST['params'];
$callback = $_REQUEST['callback'];

$factory = new EntidadFactory();
$objeto = $factory->create($tipo);

function procesa(EntidadBD $entidad, $operacion, $params, $callback) {
     if ($params != null) {
        $entidad->guardarDatos($params);        
    }
    switch ($operacion) {

        case 'pagos':
            $cliente = new Cliente();
            $cliente->cargarPagos($params,$callback);            
            break;
        case 'casos':
            $cliente = New Cliente();
            $cliente->servicioCasos($params, $callback);
            break;
    }
}

procesa($objeto, $operacion, $params, $callback);


