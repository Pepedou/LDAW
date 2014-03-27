<?php

include_once './Clases/Despacho.php';
include_once './Clases/Direccion.php';


function html(EntidadBD $entidad) {
    if (!$entidad->procesarForma(1)) {

       $entidad->generarFormaInsercion();
    }
}

$objeto = new Despacho();
?>
<?php html($objeto); ?>
