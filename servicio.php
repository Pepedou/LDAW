<?php

include_once './EntidadFactory.php';

function procesa(EntidadBD $entidad, $operacion, $params, $callback) {
    if ($params != null) {
        $entidad->guardarDatos($params);
    }
    switch ($operacion) {
        case lg:
            $abogado = new Abogado();
            $abogado->verificaLogin($params, $callback);
            break;
        case 'st':
            $entidad->service_selectTodos($callback);
            break;
        case 'si':
            $entidad->service_selectIndividual($callback);
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
    if ($params != null) {
        $entidad->guardarDatos($params);
    }
    switch ($operacion) {
        case 'st':
            $entidad->service_selectTodos($callback);
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

//$dir = new Direccion();
//$dir->guardarDatos(array(
//    "calle" => "Vasco de Quiroga",
//    "colonia" => "Santa Fe",
//    "no_exterior" => "100",
//    "no_interior" => "2A",
//    "id_Municipio" => Direccion::getIDMunicipio("Zacatecas"),
//    "ciudad" => "Ciudad de Zacatecas",
//    "id_Estado" => Direccion::getIDEstadoDeMunicipio("Zacatecas"),
//    "cp" => "01780"
//));
//$dir->almacenarEnBD();
//$doc = new Documento();
//$doc->guardarDatos(array(
//    "documento" => "doc.docx",
//    "id_Expediente" => 1,
//    "id_Tipo" => 1,
//    "visible" => 1
//));
//$doc->almacenarEnBD();
//$doc->service_selectIndividual();
//$cliente = new Cliente();
//$cliente->guardarDatos(array(
//    "nombre" => "Juan ",
//    "apellidoP" => "Pérez",
//    "apellidoM" => "Juárez",
//    "id_Direccion" => 1,
//    "telefono" => 55851891,
//    "email" => "juan@gmail.com",
//    "visible" => 1    
//));
//$cliente->almacenarEnBD();
//$cliente->printData();
//
////$log = new Log();
////$log->cargarDeBD("id", 1);
////$log->eliminarDeBD();
//
//$pago = new Pago();
//$pago->guardarDatos(array(
//    "cantidad" => 10.10,
//    "id_Cliente" => 1
//));
//
//$pago->almacenarEnBD();
//
//$pago->service_selectTodos();
//$rol = new Rol();
//$rol->guardarDatos(array(
//    "rol" => "Administrador"
//));        
//$rol->almacenarEnBD();
//$rol->service_selectIndividual();
//$rol->eliminarDeBD();
//$tarea = new Tarea();
//$tarea->guardarDatos(array(
//    "descripcion" => "Tarea1",
//    "id_Abogado" => 1,
//    "id_Caso" => 1
//));
//
//$tarea->almacenarEnBD();
//$tipo = new Tipo();
//$tipo->guardarDatos(array(
//    "tipo" => "PDF"
//));
//$tipo->eliminarDeBD();
//
//$tipo->service_selectIndividual();
//$ac = new AbogadosClientes();
//$ac->guardarDatos(array(
//    "id_Abogado" => 1,
//    "id_Cliente" => 1
//));
//
//$ac->almacenarEnBD();
//
//$abogs = $ac->cargarAbogados(); 
//
//$ac->service_selectIndividual($callback);

$reflector = new ReflectionClass($objeto);

if ($reflector->isSubclassOf('EntidadBD')) {
    procesa($objeto, $operacion, $params, $callback);
} else if ($reflector->isSubclassOf('RelacionMaM')) {
    procesaMaM($objeto, $operacion, $params, $callback);
} else {
    print_r("NULL");
}
//Para el cliente: https://stackoverflow.com/questions/17953468/how-to-pass-a-multidimensional-associative-array-in-url