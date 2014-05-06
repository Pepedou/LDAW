<?php

/**
 * Description of Complejidad
 *
 * @author José Luis Valencia Herrera     A01015544
 */
include_once 'EntidadBD.php';

class Complejidad extends EntidadBD {

    static private $tabla_static = "Complejidades";

    public function __construct() {
        parent::__construct();
        $this->tabla = static::$tabla_static;
        $this->atributos = array(
            "id" => -1,
            "complejidad" => "");
        $this->discr = "id";
        $this->discrValor = $this->atributos[$this->discr];
    }


    public function generarFormaInsercion() {
        
        static::$smarty->assign('nombre', "Nueva Complejidad");
        $data = array();

        foreach ($this->atributos as $campo => $valor) {
            if($campo !== "id" ){
                
                $data[$campo] = $campo[$valor];
            }
                       
        }
        static::$smarty->assign('data', $data);
        static::$smarty->display($this->BASE_DIR . 'Vistas/Complejidades/Altas.tpl');
        
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

    public function validarDatos() {
        
    }

//put your code here
}
