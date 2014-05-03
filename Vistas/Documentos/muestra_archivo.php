<?php

$tipo = $_REQUEST['tipo'];
$nombre = $_REQUEST['nombre'];


header("Content-type: $tipo");
header("Content-Disposition: attachment; filename=$nombre");

echo $content;