<?php

/**
 * Description of Direccion
 *
 * @author José Luis Valencia Herrera     A01015544
 */
include_once 'EntidadBD.php';

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
            "cp" => 0);
        $this->discr = "id";
        $this->discrValor = $this->atributos[$this->discr];
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

    public function service_selectTodos($callback) {
        $json = array();
        $query = "SELECT  " . static::$tabla_static . ".id, calle, no_exterior, no_interior, colonia, Municipios.Municipio, ciudad, Estados.Estado, cp from " . static::$tabla_static . " JOIN Municipios ON " . static::$tabla_static . ".id_Municipio = Municipios.id JOIN Estados ON Estados.id = Municipios.Estados_id";
        $resultado = $this->dbExecute($query);
        /* Genero el JSON con los resultados */
        if ($resultado != false) {
            while ($fila = $resultado->fetch_assoc()) {
                array_push($json, $fila);
            }
            $finalData = array("Resultados" => $json);
            if ($callback != "") {
                $json = "$callback(" . json_encode($finalData) . ")";
            } else {
                $json = json_encode($finalData);
            }
            print_r($json);
        }
        return $json;
    }

    public function service_selectIndividual($callback) {
        $json = array();
        $query = "SELECT  " . static::$tabla_static . ".id, calle, no_exterior, no_interior, colonia, Municipios.Municipio, ciudad, Estados.Estado, cp from " . static::$tabla_static . " JOIN Municipios ON " . static::$tabla_static . ".id_Municipio = Municipios.id JOIN Estados ON Estados.id = Municipios.Estados_id WHERE " . static::$tabla_static . ".id = " . $this->atributos['id'];
        $resultado = $this->dbExecute($query);
        if ($resultado != false) {
            array_push($json, ($resultado->fetch_assoc()));
            $finalData = array("Resultados" => $json);
            if ($callback != "") {
                $json = "$callback(" . json_encode($finalData) . ")";
            } else {
                $json = json_encode($finalData);
            }
            print_r($json);
        }
        return $resultado;
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
