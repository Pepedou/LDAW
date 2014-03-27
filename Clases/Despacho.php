<?php

/**
 * Description of Despacho
 *
 * @author José Luis Valencia Herrera     A01015544
 */
include_once 'EntidadBD.php';
include_once 'Direccion.php';

class Despacho extends EntidadBD {

    static private $tabla_static = "Despachos";
    static private $direccion;

    public function __construct() {
        parent::__construct();
        $this->tabla = static::$tabla_static;
        $this->atributos = array(
            "id" => -1,
            "nombre" => "NULL",
            "id_Direccion" => -1,
            "visible" => 1);
        static::$direccion = new Direccion();
        $this->discr = "nombre";
        $this->discrValor = $this->atributos[$this->discr];
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

    public function procesarForma($op) {

        switch ($op) {
            case (1):
                $dir = static::$direccion;

                foreach ($this->atributos as $campo => $valor) {

                    $this->atributos[$campo] = $_REQUEST[$campo]; //guarda el nombre del despacho
                }

                foreach ($dir->atributos as $campo => $valor) {
                    $dir->atributos[$campo] = $_REQUEST[$campo]; //guarda los atributos para la direccion              
                }
                if ($dir->atributos["calle"] != NULL) {
                    $dir->almacenarEnBD();
                    $id = $dir->getID("calle", $dir->atributos["calle"]);
                    $this->atributos["id_Direccion"] = $id;
                    if ($this->almacenarEnBD())
                        Debug::getInstance()->alert("Registro Exitoso.");
                }
                break;
            case (2):
                break;
            default :
                break;
        }
    }

    public function generarFormaInsercion() {
        static::$smarty->display($this->BASE_DIR . 'Vistas/Despachos/Crear_Despachos.tpl');
        /* static::$smarty->assign('nombre', "Prueba");
          static::$smarty->assign('data',  $this->atributos);
          static::$smarty->display($this->BASE_DIR . 'Vistas/Forma_alta.tpl'); */
    }

    public function generarFormaActualizacion() {
        
    }

    public function generarFormaBorrado($seleccion) {

        $dbM = $this->dbManager;
        $dbM->connectToDatabase();
        $query = "Select id,nombre FROM " . static::$tabla_static;
        $resultado = $dbM->executeQuery($query);

        $arreglo_valor = Array();
        $arreglo_valor[0] = "Selecciona";

        /* Agregamos los resultados a un arreglo */
        if ($resultado != false) {
            if ($resultado->num_rows > 0) {
                while ($row = $resultado->fetch_assoc()) {

                    $arreglo_valor[$row['id']] = $row['nombre'];
                }
                /* Mandamos el arreglo a la forma */
                static::$smarty->assign('opciones', $arreglo_valor);
                static::$smarty->assign('select', $seleccion);
                static::$smarty->assign('nombre', "Borrar Despachos");
                /* Imprimir documento */
                static::$smarty->display($this->BASE_DIR . 'Vistas/Despachos/Borrar_Despachos.tpl');
            } else {
                Debug::getInstance()->alert("No existen registros");
            }
        } else {
            Debug::getInstance()->alert("Error de sintaxis");
        }
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

}
