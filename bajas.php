<?php

include_once './Clases/Despacho.php';
include_once './Clases/Direccion.php';


function html(EntidadBD $entidad) {
    if (!$entidad->procesarForma(2)) {

        if (isset($_REQUEST['sel'])) {
            $entidad->generarFormaBorrado($_REQUEST['sel'], $_REQUEST['nombre']);
        } else {
            $entidad->generarFormaBorrado(0, "Selecciona");
        }
    }
}

$objeto = new Despacho();
?>
<?php html($objeto); ?>
