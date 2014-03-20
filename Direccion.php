<?php

/**
 * Description of Direccion
 *
 * @author José Luis Valencia Herrera     A01015544
 */
include_once './EntidadBD.php';

class Direccion extends EntidadBD {

    static private $tabla_static = "Direcciones";

    public function __construct() {
        parent::__construct();
        $this->tabla = static::$tabla_static;
        $this->atributos = array(
            "id" => -1,
            "calle" => "NULL",
            "no_exterior" => "NULL",
            "no_interior" => "NULL",
            "colonia" => "NULL",
            "id_Municipio" => -1,
            "ciudad" => "NULL",
            "id_Estado" => -1,
            "cp" => 0);
        $this->discr = "id";
    }

    public function generarFormaActualizacion() {
        
    }

    public function generarFormaBorrado() {
        
    }

    public function generarFormaInsercion() {
        
    }

    public function procesarForma() {
        
    }

    public function validarDatos() {
        
    }

    public static function getID($discriminante, $valor) {
        $dbManager = DatabaseManager::getInstance();
        $dbManager->connectToDatabase();
        $query = "SELECT id FROM " . static::$tabla_static . " WHERE $discriminante = '$valor' LIMIT 1";
        $resultado = $dbManager->executeQuery($query);
        $dbManager->closeConnection();
        if ($resultado != false) {
            if ($resultado->num_rows > 0) {
                $row = $resultado->fetch_assoc();
                return $row['id'];
            } else {
                return -1;
            }
        }
        Debug::getInstance()->alert("EntidadBD::getID => No se encontró el ID");
        return -1;
    }

    public static function getID_MultDiscr(array $arregloDiscrValor) {
        foreach ($arregloDiscrValor as $campo => $valor) {
            if ($campo != 'id') {
                $condicion .= "$campo = '$valor' AND ";
            }
        }
        $condicion = preg_replace('/\W\w+\s*(\W*)$/', '$1', $condicion); //Elimina el último AND

        $dbManager = DatabaseManager::getInstance();
        $dbManager->connectToDatabase();
        $query = "SELECT id FROM " . static::$tabla_static . " WHERE $condicion LIMIT 1";
        $resultado = $dbManager->executeQuery($query);
        $dbManager->closeConnection();
        if ($resultado != false) {
            if ($resultado->num_rows > 0) {
                $row = $resultado->fetch_assoc();
                return $row['id'];
            } else {
                return -1;
            }
        }
        Debug::getInstance()->alert("EntidadBD::getID => No se encontró el ID");
        return -1;
    }

    public static function getNombreTabla() {
        return static::$tabla_static;
    }

    static public function getIDMunicipio($municipio) {
        $query = "SELECT id FROM Municipios WHERE Municipio = '$municipio'";
        $dbM = DatabaseManager::getInstance();
        $dbM->connectToDatabase();
        $resultado = $dbM->executeQuery($query);
        $dbM->closeConnection();
        $fila = $resultado->fetch_assoc();
        return $fila['id'];
    }

    static public function getIDEstado($estado) {
        $query = "SELECT id FROM Estados WHERE Estado = '$estado'";
        $dbM = DatabaseManager::getInstance();
        $dbM->connectToDatabase();
        $resultado = $dbM->executeQuery($query);
        $dbM->closeConnection();
        $fila = $resultado->fetch_assoc();
        return $fila['id'];
    }

    static public function getIDEstadoDeMunicipio($municipio) {
        $query = "SELECT Estados_id FROM Municipios WHERE Municipio = '$municipio'";
        $dbM = DatabaseManager::getInstance();
        $dbM->connectToDatabase();
        $resultado = $dbM->executeQuery($query);
        $dbM->closeConnection();
        $fila = $resultado->fetch_assoc();
        return $fila['Estados_id'];
    }

}
