<?php

//include_once './Clases/Despacho.php';
include_once './Clases/Abogado.php';
//include_once './Clases/Complejidad.php';
//include_once './Clases/Caso.php';
$op = $_REQUEST['op'];
function html(EntidadBD $entidad) {
    if (!$entidad->procesarForma(1)) {

       $entidad->generarFormaInsercion();
    }
}

$objeto = new Despacho();
           


?>
<?php html($objeto); ?>
