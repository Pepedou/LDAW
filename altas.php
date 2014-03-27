<?php

//include_once './Clases/Despacho.php';
include_once './Clases/Abogado.php';

function html(EntidadBD $entidad) {
    if (!$entidad->procesarForma(1)) {

       $entidad->generarFormaInsercion();
    }
}

$objeto = new Abogado();
?>
<?php html($objeto); ?>
