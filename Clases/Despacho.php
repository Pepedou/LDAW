<?php

/**
 * Description of Despacho
 *
 * @author José Luis Valencia Herrera A01015544
 */
include_once 'EntidadBD.php';


class Despacho extends EntidadBD {

    static private $tabla_static = "Despachos";

    public function __construct() {
        parent::__construct();
        $this->tabla = static::$tabla_static;
        $this->atributos = array(
            "id" => -1,
            "nombre" => "NULL",
            "id_Direccion" => -1);
        $this->discr = "nombre";
    }

    public function validarNombre() {
        if (strlen($this->atributos['nombre']) === 0 || strlen($this->atributos['nombre']) > 50) {
            return false;
        } else {
            return true;
        }
    }

    public function validarDireccion() {
        if (strlen($this->atributos['id_Direccion']) === 0 || strlen($this->atributos['id_Direccion']) > 70) {
            return false;
        } else {
            return true;
        }
    }

    public function validarDatos() {
        if ($this->validarNombre() && $this->validarDireccion()) {
            return true;
        } else {
            return false;
        }
    }

    public function procesarForma() {
           
        $direccion = Array();
       foreach ($this->atributos as $campo => $valor){
            if(isset($_REQUEST[$campo])){
                $this->atributos[$campo] = $_REQUEST[$campo];
                if($campo == "calle"){}
            }
        }
        $this->almacenarEnBD();
        
    }

    public function generarFormaInsercion($smarty) {
        
        $smarty->display($this->BASE_DIR . 'Vistas/Despachos/Vista_Despachos.tpl');
    }

    public function generarFormaActualizacion($smarty) {
        
    }

    public function generarFormaBorrado($smarty) {
        $dbM = $this->dbManager;
        $dbM->connectToDatabase;

        $query = "Select id,nombre FROM Despachos";
        $resultado = $dbM->executeQuery($query);
        $arreglo_valor = Array();
        $arreglo_valor[0] = "Selecciona";
        
        /*Agregamos los resultados a un arreglo*/
        while ($row = $resultado->fetch_assoc()) {
          
            $arreglo_valor[$row['id']] = $row['nombre'];
        }
        /*Mandamos el arreglo a la forma*/
        $smarty->assign('opciones',$arreglo_valor);
        $smarty->assign('select', 0);
        $smarty->assign('nombre',"Borrar Despachos");
        /*Imprimir documento*/
        $smarty->display($this->BASE_DIR . 'Vistas/Despachos/Mostrar_Despachos.tpl');        
        $dbM->closeConnection();
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

    public static function getID_MultDiscr($arregloDiscrValor) {
        foreach ($arregloDiscrValor as $campo => $valor) {
            $condicion .= "$campo = '$valor' AND ";
        }
        $condicion = preg_replace('/\W\w+\s*(\W*)$/', '$1', $condicion); //Elimina el último AND

        $query = "SELECT id FROM " . static::$tabla_static . " WHERE $condicion LIMIT 1";
        $resultado = $this->dbExecute($query);
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

    
    public function agrega_Direccion($array){
        
        
        
        
    }
    
}
