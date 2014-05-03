<?php

/**
 * Description of Pago
 *
 * @author José Luis Valencia Herrera     A01015544
 */
include_once './Clases/Cliente.php';

class Pago extends EntidadBD {     

    static private $tabla_static = "Pagos";

    public function __construct() {
        parent::__construct();
        $this->tabla = static::$tabla_static;
        $this->atributos = array(       //añadir fecha
            "id" => -1,
            "cantidad" => 0.0,
            "id_Cliente" => -1,
            "visible" => 1);
        $this->discr = "id";
        $this->discrValor = $this->atributos[$this->discr];
    }

    public function cargarCliente() {
        $cliente = new Cliente();
        $query = "SELECT * FROM " . Cliente::getNombreTabla() . " WHERE id=" . $this->atributos['id_Cliente'] . " LIMIT 1";
        $resultado = $this->dbExecute($query);

        if ($resultado->num_rows) {
            $fila = $resultado->fetch_assoc();
            $cliente->guardarDatos($fila);
        }

        return $cliente;
    }

    public function generarFormaActualizacion($seleccion, $nombre, $accion, $carpeta) {
     

    }

    public function generarFormaBorrado($seleccion, $nombre) {
        
    }

    public function generarFormaInsercion() {

        static::$smarty->assign('accion', "Registrar");
        static::$smarty->assign('header', "Registrar Pago");
        static::$smarty->display($this->BASE_DIR . 'Vistas/Pagos/Altas.tpl');
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
