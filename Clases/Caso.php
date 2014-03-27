<?php

/**
* Clase para la creación, actualización y borrado de Casos
*
* @author José Luis Valencia Herrera A01015544
*/
include_once 'EntidadBD.php';
include_once 'Despacho.php';

class Caso extends EntidadBD {

    static private $tabla_static = "Casos";

    public function __construct() {
        parent::__construct();
        $this->tabla = static::$tabla_static;
        $this->atributos = array(
            "id" => -1,
            "nombre" => "",
            "status" => 0,
            "id_Despacho" => -1,
            "visible" => 1);
        $this->discr = "nombre";
        $this->discrValor = $this->atributos[$this->discr];
    }

    public function cargarDespacho() {
        $despacho = new Despacho();
        $query = "SELECT * FROM " . Despacho::getNombreTabla() . " WHERE id=" . $this->atributos['id_Despacho'] . " LIMIT 1";
        $resultado = $this->dbExecute($query);
        Debug::getInstance()->alert($query);

        if ($resultado->num_rows) {
            $fila = $resultado->fetch_assoc();
            $despacho->guardarDatos($fila);
        }

        return $despacho;
    }

    public function generarFormaActualizacion() {
        
    }

    public function generarFormaBorrado($seleccion) {
        
    }

    public function generarFormaInsercion() {
        static::$smarty->assign('nombre', "Nuevo Caso");
        $data = array();

        foreach ($this->atributos as $campo => $valor) {
            if($campo !== "id" && $campo !== "visible" && $campo !== "id_Despacho" && $campo !==status){
                
                $data[$campo] = $campo[$valor];
            }
                       
        }
        static::$smarty->assign('data', $data);
        static::$smarty->display($this->BASE_DIR . 'Vistas/Casos/Altas.tpl');
    }

    public function procesarForma($op) {
        
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

}

