<!doctype html>
 <head>
<?php
include_once './Despacho.php';

function html(EntidadBD $entidad) {
    if (!$entidad->procesarForma()) {
        $entidad->generarFormaInsercion();
    }
}

$objeto = new Despacho();
?>
   
        <meta charset="UTF-8">
        <title></title>
</head>
    
<?php html($objeto); ?>
    </body>
</html>
