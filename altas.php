<?php

include_once './Clases/Despacho.php';
include_once './Clases/Abogado.php';
//include_once './Clases/Complejidad.php';
include_once './Clases/Caso.php';
include_once './Clases/Cliente.php';
include_once './Clases/Expediente.php';
include_once './Clases/Documento.php';
include_once './Clases/Pago.php';
include_once './Clases/Tarea.php';

$op = $_REQUEST['op'];

function html(EntidadBD $entidad) {
    if (!$entidad->procesarForma(1)) {

        $entidad->generarFormaInsercion();
    }
}

switch ($op) {

    case 'Despacho':
        $objeto = new Despacho();
        break;
    
    case 'Abogado':
        $objeto = new Abogado();
        break;
    case 'Cliente':
        $objeto = new Cliente();
        break;
    case 'Caso':
        $objeto = new Caso();
        break;
    case 'Expediente':
        $objeto = new Expediente();
        break;
    case 'Pago':
        $objeto = new Pago();
        break;
    case 'Tarea':
        $objeto = new Tarea();
        break;
    default :
        Debug::getInstance()->alert("Entidad no Encontrada");
        break;
}
?>
<?php html($objeto); ?>
