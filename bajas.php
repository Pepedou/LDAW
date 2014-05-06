<?php

//include_once './Clases/Despacho.php';
//include_once './Clases/Direccion.php';
include_once './Clases/Abogado.php';
include_once './Clases/Caso.php';
include_once './Clases/Cliente.php';
include_once './Clases/Expediente.php';
include_once './Clases/Documento.php';

$op = $_REQUEST['op'];

function html(EntidadBD $entidad) {
    if (!$entidad->procesarForma(2)) {

        if (isset($_REQUEST['sel'])) {
            $entidad->generarFormaActualizacion($_REQUEST['sel'], $_REQUEST['nombre'], "Eliminar", "Bajas");
        } else {
            $entidad->generarFormaActualizacion(0, "Selecciona", "Eliminar", "Bajas");
        }
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
    default :
        Debug::getInstance()->alert("Entidad no Encontrada");
        break;
}
?>
<?php html($objeto); ?>
