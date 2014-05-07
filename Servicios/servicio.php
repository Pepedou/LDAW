<?php

include_once '../Clases/EntidadFactory.php';

function procesa(EntidadBD $entidad, $operacion, $params, $callback) {
    if ($params != null) {
        $entidad->guardarDatos($params);        
    }
    switch ($operacion) {
        case 'lg':
            $abogado = new Abogado();
            $abogado->verificaLogin($params, $callback);
            break;
         case 'lgc':
            $cliente = new Cliente();
            $cliente->verificaLogin($params, $callback);
            break;
        case 'st':
            $entidad->guardarDatos($params);     
            $entidad->service_selectTodos($callback);
            break;
        case 'si':
            $entidad->service_selectIndividual($callback);
            break;
        case 'sii':
            $entidad->service_selectIndividualID($callback);
            break;
        case 'in':
            $entidad->service_insert($callback);
            break;
        case 'up':
            $entidad->service_update($callback);
            break;
        case 'del':
            $entidad->service_delete($callback);
            break;
    }
}

function procesaMaM(RelacionMaM $entidad, $operacion, $params, $callback) {
    $entidad->guardarDatos($params);
    switch ($operacion) {
        case 'st':
            $entidad->service_selectTodos($callback);
            break;
        case 'sti':
            $entidad->service_selectTodosID($params, $callback);
            break;
        case 'si':
            $entidad->service_selectIndividual($callback);
            break;
        case 'in':
            $entidad->service_insert($callback);
            break;
        case 'del':
            $entidad->service_delete($callback);
            break;
    }
}

$tipo = $_GET['entidad'];
$operacion = $_GET['op'];
$params = $_REQUEST['params'];
$callback = $_REQUEST['callback'];

$factory = new EntidadFactory();
$objeto = $factory->create($tipo);

$reflector = new ReflectionClass($objeto);

if ($reflector->isSubclassOf('EntidadBD')) {
    procesa($objeto, $operacion, $params, $callback);
} else if ($reflector->isSubclassOf('RelacionMaM')) {
    procesaMaM($objeto, $operacion, $params, $callback);
} else {
    print_r("NULL");
}