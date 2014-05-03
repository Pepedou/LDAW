<?php

/**
* Description of EntidadFactory
*
* @author José Luis Valencia Herrera A01015544
*/
include_once './Clases/Abogado.php';
include_once './Clases/Despacho.php';
include_once './Clases/Direccion.php';
include_once './Clases/Complejidad.php';
include_once './Clases/Documento.php';
include_once './Clases/Caso.php';
include_once './Clases/Cliente.php';
include_once './Clases/Log.php';
include_once './Clases/Pago.php';
include_once './Clases/Rol.php';
include_once './Clases/Tarea.php';
include_once './Clases/Tipo.php';
include_once './Clases/AbogadosCasos.php';
include_once './Clases/AbogadosClientes.php';

class EntidadFactory {
    
    public function create($objName){
        switch($objName){
            case 'Abogado':
                return new Abogado();
            case 'Despacho':
                return new Despacho();
            case 'Direccion':
                return new Direccion();
            case 'Complejidad':
                return new Complejidad();
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
            case 'Tipo':
                return new Tipo();
            case 'AbogadosCasos':
                return new AbogadosCasos();
            case 'AbogadosClientes':
                return new AbogadosClientes();
        }
    }
    
}