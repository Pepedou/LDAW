<?php

include './Despacho.php';

$accion = $_REQUEST['accion'];

if ($accion == "Delete") {
    $despacho = new Despacho();
    $despacho->id = $_REQUEST['id'];
    //$id = $despacho->get_Nombre();
    $despacho->eliminarDeBD();
} else if ($accion == "Insert") {

    $despacho = new Despacho();
    $despacho->nombre = $_REQUEST['nombre'];
    $despacho->direccion = $_REQUEST['direccion'];
    $despacho->almacenarEnBD();
} else {
  //Aquí qué va?  
}
?>