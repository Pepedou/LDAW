<?php

include_once 'Clases/EntidadFactory.php';

$op = $_REQUEST['op'];

function html(EntidadBD $entidad) {
    if (!$entidad->procesarForma(1)) {
        $entidad->generarFormaInsercion();
    }
}

$factory = new EntidadFactory();
$objeto = $factory->create($op);

html($objeto);
?>
