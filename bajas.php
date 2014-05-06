<?php

include_once 'Clases/EntidadFactory.php';

$op = $_REQUEST['op'];

function html(EntidadBD $entidad) {
    if (!$entidad->procesarForma(2)) {

        if (isset($_REQUEST['sel'])) {
            $entidad->generarFormaActualizacion($_REQUEST['sel'], $_REQUEST['nombre'], "Eliminar", "Bajas");
        } else {
            $entidad->generarFormaActualizacion(0, "Selecciona", "Eliminar", "Bajas");
        }
    }
}

$factory = new EntidadFactory();
$objeto = $factory->create($op);

html($objeto); ?>
