<?php

include_once 'Clases/EntidadFactory.php';

$op = $_REQUEST['op'];

function html(EntidadBD $entidad) {
    if (!$entidad->procesarForma(3)) {
        if (isset($_REQUEST['sel'])) {
            $entidad->generarFormaActualizacion($_REQUEST['sel'], $_REQUEST['nombre'], "Actualizar", "Cambios");
        } else {
            $entidad->generarFormaActualizacion(0, "Selecciona", "Actualizar", "Cambios");
        }
    }
}

$factory = new EntidadFactory();
$objeto = $factory->create($op);

html($objeto);
?>
