<?php

/**
 * Description of Expediente
 *
 * @author José Luis Valencia Herrera     A01015544
 */
include_once 'EntidadBD.php';
include_once 'Caso.php';

class Expediente extends EntidadBD {

    static private $tabla_static = "Expedientes";

    public function __construct() {
        parent::__construct();
        $this->tabla = static::$tabla_static;
        $this->atributos = array(
            "id" => -1,
            "nombre" => "",
            "id_Caso" => -1, 
            "visible" => 1);
        $this->discr = "id";
        $this->discrValor = $this->atributos[$this->discr];
    }

    public function cargarDireccion() {
        $caso = new Caso();
        $query = "SELECT * FROM " . Caso::getNombreTabla() . " WHERE id=" . $this->atributos['id_Caso'] . " LIMIT 1";
        $resultado = $this->dbExecute($query);

        if ($resultado->num_rows) {
            while ($fila = $resultado->fetch_assoc()) {
                $caso->guardarDatos($fila);
            }
        }

        return $caso;
    }

    public function generarFormaActualizacion($seleccion, $nombre, $accion, $carpeta) {
        
        $name = "Selecciona";
        $sel_caso = 0;

        if ($nombre !== "Selecciona") {
            $exp = new Expediente();
            $exito = $exp->cargarDeBD("nombre", $nombre);
            if ($exito) {
                /* Actualizo el valor de name */
                $name = $exp->atributos["nombre"];
                $sel_caso = $exp->atributos["id_Caso"];
                /* Cargo la direccion */
                $case = new Caso();
                $exito2 = $case->cargarDeBD("id", $exp->atributos['id_Caso']);
                if ($exito2) {

                    $exp_caso = $case->atributos["nombre"];
    }
            }
        }
        static::$smarty->assign('nombre', $accion . "Expedientes");
        static::$smarty->assign('exp_nombre', $name);
        static::$smarty->assign('exp_caso', $exp_caso);
        static::$smarty->assign('sel_desp', $sel_caso);
        static::$smarty->assign('sel', $seleccion);
        static::$smarty->assign('name', "expedientes");
        static::$smarty->assign('tabla', "Expedientes");
        static::$smarty->assign('campo', "nombre");
        static::$smarty->assign('accion', $accion);
        /* Imprimir documento */
        static::$smarty->display($this->BASE_DIR . 'Vistas/Expedientes/' . $carpeta . '.tpl');
    }
    
    public function generarFormaInsercion() {
        static::$smarty->assign('nombre', "Nuevo Abogado");
        static::$smarty->assign('accion', "Registrar");
        static::$smarty->assign('header', "Alta de Expedientes");
        
        static::$smarty->display($this->BASE_DIR . 'Vistas/Expedientes/Altas.tpl');
    }

    public function procesarForma($op) {
        
        switch ($op) {

            case 1: //alta           

                $this->procesa_insert();
                break;
            case 2:
                $this->procesa_bajas();
                break;
            case 3:
                $this->procesa_cambios();
                break;
            default :
                break;
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

    public function generarFormaBorrado($seleccion, $nombre) {
        
    }

    public function validarDatos() {
        
    }

}
