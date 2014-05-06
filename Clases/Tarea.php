<?php

/**
 * Description of Tarea
 *
 * @author José Luis Valencia Herrera     A01015544
 */
include_once 'Abogado.php';
include_once 'Caso.php';

class Tarea extends EntidadBD {

    static private $tabla_static = "Tareas";

    public function __construct() {
        parent::__construct();
        $this->tabla = static::$tabla_static;
        $this->atributos = array(
            "id" => -1,
            "nombre" => "",
            "descripcion" => "",
            "inicio" => date("Y-m-d"),
            "fin" => date("Y-m-d"),
            "status" => 1,
            "id_Abogado" => -1,
            "id_Caso" => -1,
            "visible" => 1);
        $this->discr = "id";
        $this->discrValor = $this->atributos[$this->discr];
    }

    public function cargarAbogado() {
        $abogado = new Abogado();

        $query = "SELECT * FROM " . Abogado::getNombreTabla() . " WHERE id=" . $this->atributos['id_Abogado'] . " LIMIT 1";
        $resultado = $this->dbExecute($query);
        Debug::getInstance()->alert($query);

        if ($resultado != false && $resultado->num_rows) {
            while ($fila = $resultado->fetch_assoc()) {
                $abogado->guardarDatos($fila);
            }
        }

        return $abogado;
    }

    public function cargarCaso() {
        $caso = new Caso();

        $query = "SELECT * FROM " . Caso::getNombreTabla() . " WHERE id=" . $this->atributos['id_Caso'] . " LIMIT 1";
        $resultado = $this->dbExecute($query);
        Debug::getInstance()->alert($query);

        if ($resultado != false && $resultado->num_rows) {
            while ($fila = $resultado->fetch_assoc()) {
                $caso->guardarDatos($fila);
            }
        }

        return $caso;
    }

    public function generarFormaActualizacion() {
        
    }

    public function generarFormaBorrado() {
        
    }

    public function generarFormaInsercion() {
        
        setlocale(LC_TIME, 'es_ES'); //poner los datos de los meses en español
        // esto es lo que trae StartDateMonth=01&StartDateDay=1&StartDateYear=2014
        static::$smarty->assign('nombre', "Nueva Tarea");
        static::$smarty->assign('accion', "Registrar");
        static::$smarty->assign('header', "Alta de Tareas");
        static::$smarty->display($this->BASE_DIR . 'Vistas/Tareas/Altas.tpl');
    }

    public function procesarForma($op) {
        switch ($op) {
        
            case 1: //alta           

                foreach ($this->atributos as $campo => $valor) {
                    if (isset($_REQUEST[$campo])) {

                        $this->atributos[$campo] = $_REQUEST[$campo];
    }
                }
                $anio = $_REQUEST['StartDateYear'];
                $dia = $_REQUEST['StartDateDay'];
                $mes = $_REQUEST['StartDateMonth'];
                $fecha = "$anio" . "-$mes" . "-$dia";
                $date = date("Y-m-d", strtotime($fecha));
                $this->atributos['fin'] = $date;
                Debug::getInstance()->alert("Fecha:" . $fecha);

                if ($this->all_set()) {
                    if ($this->almacenarEnBD()) {
                        Debug::getInstance()->alert("Registro Exitoso.");
                    }
                } else {
                    (Debug::getInstance()->alert("Faltan Campos"));
                }

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
            if ($campo != 'id' && $campo != 'fin' && campo != 'inicio') {

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

    public function all_set() {
        $count = 0;
        $att_count = count($this->atributos) - 5; //menos id, inicio,fin y visible

        foreach ($this->atributos as $campo => $valor) {
            if ($campo != 'id' && $campo != 'inicio' && $campo != 'visible' && $campo != 'fin') {

                if (isset($_REQUEST[$campo])) {

                    $count = $count + 1;
}
            }
        }

        if ($count === $att_count) {

            return true;
        } else {
            return false;
        }
    }

    
}
