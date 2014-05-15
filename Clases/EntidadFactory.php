<?php

/**
 * Description of EntidadFactory
 *
 * @author José Luis Valencia Herrera     A01015544
 */
include_once 'Abogado.php';
include_once 'Despacho.php';
include_once 'Direccion.php';
include_once 'Expediente.php';
include_once 'Documento.php';
include_once 'Caso.php';
include_once 'Cliente.php';
include_once 'Log.php';
include_once 'Pago.php';
include_once 'Rol.php';
include_once 'Tarea.php';
include_once 'AbogadosCasos.php';
include_once 'AbogadosClientes.php';
include_once 'ComentarioCaso.php';
include_once 'ComentarioTarea.php';

class EntidadFactory {

    public function create($objName) {
        switch ($objName) {
            case 'Abogado':
                return new Abogado();
            case 'Despacho':
                return new Despacho();
            case 'Direccion':
                return new Direccion();
            case 'Expediente':
                return new Expediente();
            case 'Documento':
                return new Documento();
            case 'Caso':
                return new Caso();
            case 'Cliente':
                return new Cliente();
            case 'Log':
                return new Log();
            case 'Pago':
                return new Pago();
            case 'Rol':
                return new Rol();
            case 'Tarea':
                return new Tarea();
            case 'AbogadosCasos':
                return new AbogadosCasos();
            case 'AbogadosClientes':
                return new AbogadosClientes();
            case 'ComentarioCaso':
                return new ComentarioCaso();
            case 'ComentarioTarea':
                return new ComentarioTarea();
        }
    }

}
