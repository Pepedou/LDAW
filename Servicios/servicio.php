<?php

include_once '../Clases/EntidadFactory.php';

function procesa(EntidadBD $entidad, $operacion, $params, $callback) {
    if ($params != null) {
        $entidad->guardarDatos($params);
    }
    switch ($operacion) {
        case 'lg'://Login abogado
            $abogado = new Abogado();
            $abogado->verificaLogin($params, $callback);
            break;
        case 'lgc'://Login clientes
            $cliente = new Cliente();
            $cliente->verificaLogin($params, $callback);
            break;
        case 'gcal'://Get callificaciones abogados
            $abogado = new Abogado();
            $abogado->service_getcalificacion($params, $callback);
            break;
        case 'scal'://Set calificaciones abogados
            $abogado = new Abogado();
            $abogado->service_setcalificacion($params, $callback);
            break;
        case 'st'://Select todos
            $entidad->service_selectTodos($callback);
            break;
        case 'stw'://Select todos where
            $entidad->service_selectTodosWhere($params, $callback);
            break;
        case 'si'://Select individual
            $entidad->service_selectIndividual($callback);
            break;
        case 'sii':
            $entidad->service_selectIndividualID($callback);
            break;
        case 'in':
            $entidad->service_insert($callback);
            break;
        case 'up':
            $entidad->cargarDeBD($entidad->getDiscriminante(), $params[$entidad->getDiscriminante()]);
            $entidad->guardarDatos($params);
            $entidad->service_update($callback);
            break;
        case 'del':
            $entidad->service_delete($callback);
            break;
        case 'stu'://Select tareas urgentes
            $tarea = new Tarea();
            $tarea->service_tareasUrgentes($params, $callback);
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