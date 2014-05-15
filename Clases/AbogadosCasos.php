<?php

/**
 * Description of AbogadosCasos
 *
 * @author José Luis Valencia Herrera     A01015544
 */
include_once 'RelacionMaM.php';
include_once 'Abogado.php';
include_once 'Caso.php';

class AbogadosCasos extends RelacionMaM {

    static private $tabla_static = "Abogados_Casos";

    public function __construct() {
        parent::__construct();
        $this->tabla = static::$tabla_static;
        $this->atributos = array(
            "id" => -1,
            "id_Abogado" => -1,
            "id_Caso" => -1
        );
    }

    public function cargarCasos() {
        $casos = array();
        $aux = new Caso();
        $query = "SELECT * FROM " . Caso::getNombreTabla() . " JOIN " . static::$tabla_static . " on " . Caso::getNombreTabla() . ".id = " . static::$tabla_static . ".id_Caso WHERE " . static::$tabla_static . ".id_Abogado = " . $this->atributos['id_Abogado'];

        $resultado = $this->dbExecute($query);

        if ($resultado->num_rows) {
            $fila = $resultado->fetch_assoc();
            $aux->guardarDatos($fila);
            array_push($casos, $aux);
        }

        return $casos;
    }

    public function cargarAbogados() {
        $abogados = array();
        $aux = new Abogado();
        $query = "SELECT * FROM " . Abogado::getNombreTabla() . " JOIN " . static::$tabla_static . " on " . Abogado::getNombreTabla() . ".id = " . static::$tabla_static . ".id_Abogado WHERE " . static::$tabla_static . ".id_Caso = " . $this->atributos['id_Caso'];


        $resultado = $this->dbExecute($query);

        if ($resultado->num_rows) {
            $fila = $resultado->fetch_assoc();
            $aux->guardarDatos($fila);
            array_push($abogados, $aux);
        }

        return $abogados;
    }

    public static function getNombreTabla() {
        return static::$tabla_static;
    }

    public function service_selectTodosID($misDatos, $callback) {
        $resultados = array();
        $atributos = array();
        switch ($misDatos['campo']) {
            case 'Abogado':
            case 'Abogados':
                $resultados = $this->cargarAbogados();
                break;
            case 'Caso':
            case 'Casos':
                $resultados = $this->cargarCasos();
                break;
        }

        foreach ($resultados as $objeto) {
            array_push($atributos, $objeto->atributos);
        }
        $finalData = array("Resultados" => $atributos);
        if ($callback != "") {
            $json = "$callback(" . json_encode($finalData) . ")";
        } else {
            $json = json_encode($finalData);
        }
        print_r($json);
    }

    public function generarFormaActualizacion() {
        
    }

    public function generarFormaBorrado() {
        
    }

    public function generarFormaInsercion() {
        
    }

    public function procesarForma() {
        
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

}
