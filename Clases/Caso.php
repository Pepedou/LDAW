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

    public function generarFormaActualizacion($seleccion, $nombre, $accion, $carpeta) {
        $name = "Selecciona";
        $sel_status = 0;
        $sel_desp = 0;

        if ($nombre !== "Selecciona") {
            $caso = new Caso();
            $exito = $caso->cargarDeBD("nombre", $nombre);
            if ($exito) {
                /* Actualizo el valor de name */
                $name = $caso->atributos["nombre"];
                $sel_status = $caso->atributos["status"];
                $sel_desp = $caso->atributos["id_Despacho"];

                /* Status del Caso */
                if ($sel_status === 1) {
                    $caso_status = "Activo";
                } else {
                    $caso_status = "Inactivo";
                }

                $desp = new Despacho();
                $exito2 = $desp->cargarDeBD("id", $sel_desp);
                if ($exito2) {

                    $caso_desp = $desp->atributos["nombre"];
                } else {
                    $caso_desp = "No encontrado";
                }
            }
        }

        $caso_desp = $desp->atributos["nombre"];
        static::$smarty->assign('caso_nombre', $name);
        static::$smarty->assign('nombre', $accion . "Despachos");
        static::$smarty->assign('select_status', $sel_status);
        static::$smarty->assign('select_desp', $sel_desp);
        static::$smarty->assign('caso_status', $caso_status);
        static::$smarty->assign('caso_desp', $caso_desp);
        static::$smarty->assign('sel', $seleccion);
        static::$smarty->assign('name', "casos");
        static::$smarty->assign('tabla', "Casos");
        static::$smarty->assign('campo', "nombre");
        static::$smarty->assign('accion', $accion);
        /* Imprimir documento */
        static::$smarty->display($this->BASE_DIR . 'Vistas/Casos/' . $carpeta . '.tpl');
    }

    public function generarFormaBorrado($seleccion, $nombre) {
        
    }

    public function generarFormaInsercion() {

        static::$smarty->assign('accion', "Registrar");
        static::$smarty->assign('header', "Nuevo Caso");
        static::$smarty->display($this->BASE_DIR . 'Vistas/Casos/Altas.tpl');
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

    public function validarDatos() {
        
    }

    public static function getID($discriminante, $valor) {
        $dbManager = DatabaseManager::getInstance();
        $dbManager->connectToDatabase();
        $query = "SELECT id FROM " . static::$tabla_static . " WHERE ".$discriminante ." = '$valor' LIMIT 1";
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
