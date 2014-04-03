<?php

include_once './Clases/Despacho.php';

//include_once './Clases/Abogado.php';
//include_once './Clases/Complejidad.php';
//include_once './Clases/Caso.php';

function html(EntidadBD $entidad) {
    if (!$entidad->procesarForma(3)) {
        if (isset($_REQUEST['sel'])) {
            $entidad->generarFormaActualizacion($_REQUEST['sel'], $_REQUEST['nombre']);
        } else {
            $entidad->generarFormaActualizacion(0, "Selecciona");
        }
    }
}

$objeto = new Despacho();
?>
<?php html($objeto); ?>
