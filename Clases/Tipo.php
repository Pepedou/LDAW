<?php

/**
 * Description of Tipo
 *
 * @author José Luis Valencia Herrera     A01015544
 */
include_once 'EntidadBD.php';

class Tipo extends EntidadBD {

    static private $tabla_static = "Tipos";

    public function __construct() {
        parent::__construct();
        $this->tabla = static::$tabla_static;
        $this->atributos = array(
            "id" => -1,
            "tipo" => "");
        $this->discr = "id";
        $this->discrValor = $this->atributos[$this->discr];
    }

    public function eliminarDeBD() {
        $query = "DELETE FROM " . static::$tabla_static . " WHERE id = " . $this->atributos['id'];
        $resultado = $this->dbExecute($query);
        if ($resultado === true) {
            Debug::getInstance()->alert("Rol " . $this->atributos['id'] . " eliminado exitosamente.");
            return true;
        } else {
            Debug::getInstance()->alert("Rol " . $this->atributos['id'] . " no se pudo eliminar.");
            return false;
        }
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
        if ($resultado != false && $resultado->num_rows) {
            $row = $resultado->fetch_assoc();
            return $row['id'];
        } else {
            return -1;
        }
    }

    public static function getNombreTabla() {
        return static::$tabla_static;
    }

    public function generarFormaActualizacion($seleccion, $nombre, $accion, $carpeta) {
        
    }

    public function generarFormaBorrado($seleccion, $nombre) {
        
    }

    public function generarFormaInsercion() {
        
    }

    public function validarDatos() {
        
    }

}
