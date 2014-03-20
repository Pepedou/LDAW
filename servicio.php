<?php

include_once './Abogado.php';
include_once './Despacho.php';
include_once './Direccion.php';
include_once './Complejidad.php';
include_once './Documento.php';
include_once './Caso.php';
include_once './Cliente.php';

function procesa(EntidadBD $entidad, $operacion, $params) {
    $entidad->guardarDatos($params);
    switch ($operacion) {
        case 'st':
            $entidad->service_selectTodos();
            break;
        case 'si':
            $entidad->service_selectIndividual();
            break;
        case 'in':
            $entidad->service_insert();
            break;
        case 'up':
            $entidad->service_update();
            break;
        case 'del':
            $entidad->service_delete();
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
//    "id_Direccion" => $dir->atributos['id'],
//    "telefono" => 55851891,
//    "email" => "juan@gmail.com",
//    "visible" => 1    
//));
//$cliente->almacenarEnBD();
//$cliente->printData();

//procesa($objeto, $operacion, $params);

//Para el cliente: https://stackoverflow.com/questions/17953468/how-to-pass-a-multidimensional-associative-array-in-url