<!doctype html>
<?php
include_once './Despacho.php';

function html(EntidadBD $entidad) {
    if (!$entidad->procesarForma()) {
        $entidad->generarFormaInsercion();
    }
}

$objeto = new Despacho();
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <h1>Altas</h1>
<?php html($objeto); ?>
    </body>
</html>
