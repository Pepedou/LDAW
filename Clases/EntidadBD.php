<?php

use Debug;

include './DatabaseManager.php';

/**
 * Description of EntidadBD
 *
 * @author José Luis Valencia Herrera     A01015544
 */
abstract class EntidadBD {

    protected $id, $debug, $dbManager;

    protected function __construct() {
        $this->debug = Debug::getInstance();
        $this->dbManager = DatabaseManager::getInstance();
    }

    abstract public function cargarDeBD($entidad);

    abstract public function almacenarEnBD();

    abstract public function eliminarDeBD();

    abstract public function generarFormaInsercion();

    abstract public function generarFormaActualizacion();

    abstract public function generarFormaBorrado();

    abstract public function procesarForma();

    abstract public function guardarDatos(array $misDatos = array());

    abstract public function validarDatos();

    public function setID($id) {
        $this->id = $id;
    }

    public function getID() {
        return $this->id;
    }

}
