<?php

include_once 'ServicioGenerico.php';
include_once '/home/ldaw-1018566/html_container/content/Proyecto/Smarty/libs/Smarty.class.php';

/**
 * Description of EntidadBD
 *
 * @author José Luis Valencia Herrera     A01015544
 */
abstract class EntidadBD extends ServicioGenerico {

    protected $debug, $dbManager, $existente;
    static public $BASE_DIR;
    static public $smarty;
    protected function __construct() {
        $this->debug = Debug::getInstance();
        $this->dbManager = DatabaseManager::getInstance();
        $this->existente = false;
        $this->BASE_DIR = '/home/ldaw-1018566/html_container/content/Proyecto/';
        static::$smarty = new Smarty;
        static::$smarty->template_dir = static::$BASE_DIR . 'Smarty/demo/templates/';
        static::$smarty->compile_dir = static::$BASE_DIR . 'Smarty/demo/templates_c/';
    }

    abstract static public function getID($discriminante, $valor);

    abstract static public function getID_MultDiscr($arregloDiscrValor);

    public function revisarExistencia($discriminante, $valor) {
        $query = "SELECT COUNT(id) FROM $this->tabla WHERE $discriminante = '$valor' LIMIT 1";
        $resultado = $this->dbExecute($query);
        if ($resultado != false) {
            $row = $resultado->fetch_assoc();
            if ($row['COUNT(id)'] > 0) {
                $this->existente = true;
                return true;
            } else {
                $this->existente = false;
                return false;
            }
        } else {
            $this->debug->alert("EntidadBD::revisarExistencia => Error en la consulta");
            return false;
        }
    }

    public function revisarExistencia_MultDiscr($arregloDiscrValor) {
        foreach ($arregloDiscrValor as $campo => $valor) {
            $condicion .= "$campo = '$valor' AND ";
        }
        $condicion = preg_replace('/\W\w+\s*(\W*)$/', '$1', $condicion); //Elimina el último AND
        
        $query = "SELECT COUNT(id) FROM $this->tabla WHERE $condicion LIMIT 1";
        $resultado = $this->dbExecute($query);
        if ($resultado != false) {
            $row = $resultado->fetch_assoc();
            if ($row['COUNT(id)'] > 0) {
                $this->existente = true;
                return true;
            } else {
                $this->existente = false;
                return false;
            }
        } else {
            $this->debug->alert("EntidadBD::revisarExistencia => Error en la consulta");
            return false;
        }
    }

    public function cargarDeBD($discriminante, $valor) {
        $query = "SELECT * FROM $this->tabla WHERE $discriminante = '$valor' LIMIT 1";
        $resultado = $this->dbExecute($query);
        if ($resultado != false) {
            foreach ($resultado->fetch_assoc() as $campo => $valor) {
                $this->atributos[$campo] = $valor;
            }
            $this->existente = true;
            $this->actualizarValorDiscr();
            return true;
        } else {
            Debug::getInstance()->alert("EntidadBD::cargarDeBD => No se pudo cargar.");
            return false;
        }
    }

    public function cargarDeBD_MultDiscr($arregloDiscrValor) {
        foreach ($arregloDiscrValor as $campo => $valor) {
            $condicion .= "$campo = '$valor' AND ";
        }
        $condicion = preg_replace('/\W\w+\s*(\W*)$/', '$1', $condicion); //Elimina el último AND
        $query = "SELECT * FROM $this->tabla WHERE $condicion LIMIT 1";
        $resultado = $this->dbExecute($query);
        if ($resultado != false) {
            foreach ($resultado->fetch_assoc() as $campo => $valor) {
                $this->atributos[$campo] = $valor;
            }
            $this->existente = true;
            return true;
        } else {
            Debug::getInstance()->alert("EntidadBD::cargarDeBD_MultDiscr => No se pudo cargar.");
            return false;
        }
    }

    public function almacenarEnBD() {
        if (!$this->existente) {//Reviso si ya existe, si no, lo creo
            foreach ($this->atributos as $campo => $campoValor) {//Genero string de campos y valores
                if ($campo != "id") {
                    $subqueryCamps .= $campo . ",";
                    $subqueryVals .= "'" . $campoValor . "',";
                }
            }
            $subqueryCamps = rtrim($subqueryCamps, ","); //Elimina la última coma
            $subqueryVals = rtrim($subqueryVals, ","); //Elimina la última coma

            $query = "INSERT INTO $this->tabla ($subqueryCamps) VALUES ($subqueryVals)";
            $resultado = $this->dbExecute($query);
            if ($resultado != false) {
                $this->cargarDeBD($this->discr, $this->atributos[$this->discr]);
                $this->actualizarValorDiscr(); //Me aseguro de que el discriminante tenga el valor correcto
                return true;
            } else {
                Debug::getInstance()->alert("EntidadBD::almacenarEnBD => No se pudo insertar.");
                return false;
            }
        } else {//Si ya existe, actualizo los valores 
            /* Obtengo el ID real, es importante que el valor del discriminante
             * sea el mismo que tenía originalmente mediante $this->actualizarValorDiscr();
             */
            $this->atributos['id'] = static::getID($this->discr, $this->discrValor);

            foreach ($this->atributos as $campo => $valor) {//Creo asignaciones SQL
                if ($campo != "id") {
                    $subquerySets .= $campo . "='" . $valor . "',";
                }
            }
            $subquerySets = rtrim($subquerySets, ","); //Elimina la última coma

            $query = "UPDATE $this->tabla SET $subquerySets WHERE id = '" . $this->atributos['id'] . "'";
            $resultado = $this->dbExecute($query);
            if ($resultado === true) {
                $this->actualizarValorDiscr();
                return true;
            } else {
                Debug::getInstance()->alert("EntidadBD::almacenarEnBD => No se pudo actualizar.");
                return false;
            }
        }
    }

    public function eliminarDeBD() {
        $query = "UPDATE $this->tabla SET visible = 0 WHERE id = '$this->atributos['id']'";
        $resultado = $this->dbExecute($query);
        if ($resultado === true) {
            return true;
        } else {
            Debug::getInstance()->alert("EntidadBD::eliminarDeBD => No se pudo eliminar.");
            return false;
        }
    }

    public function printData() {
        print_r($this->atributos);
    }

    abstract public function generarFormaInsercion($smarty);

    abstract public function generarFormaActualizacion($smarty);

    abstract public function generarFormaBorrado($smarty);

    public function procesarForma(){
        foreach ($this->atributos as $campo => $valor){
            if(isset($_REQUEST[$campo])){
                $this->atributos[$campo] = $_REQUEST[$campo];
            }
        }
        $this->almacenarEnBD();
    }

    public function guardarDatos($misDatos) {
        foreach ($this->atributos as $campo) {
            $this->atributos[$campo] = $misDatos[$campo];
        }
    }

    protected function actualizarValorDiscr() {
        $this->discrValor = $this->atributos[$this->discr];
    }

    abstract public function validarDatos();
}
