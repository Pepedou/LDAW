<?php

/**
 * Clase para la creación, actualización y borrado de Casos
 *
 * @author José Luis Valencia Herrera A01015544
 */
include_once 'EntidadBD.php';
include_once 'Despacho.php';
include_once 'Expediente.php';

class Caso extends EntidadBD {

    static private $tabla_static = "Casos";

    public function __construct() {
        parent::__construct();
        $this->tabla = static::$tabla_static;
        $this->atributos = array(
            "id" => -1,
            "nombre" => "",
            "descripcion" => "",
            "status" => 0,
            "id_Despacho" => -1,
            "id_Cliente" => -1,
            "visible" => 1);
        $this->discr = "nombre";
        $this->discrValor = $this->atributos[$this->discr];
    }

    public function cargarDespacho() {
        $despacho = new Despacho();
        $query = "SELECT * FROM " . Despacho::getNombreTabla() . " WHERE id=" . $this->atributos['id_Despacho'] . " LIMIT 1";
        $resultado = $this->dbExecute($query);

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
        $sel_cliente = 0;
        $caso_descrip = "";
        $caso_id = 0;
        
        
        if ($nombre !== "Selecciona") {
            $caso = new Caso();
            $exito = $caso->cargarDeBD("nombre", $nombre);
            if ($exito) {
                /* Actualizo el valor de name */
                $name = $caso->atributos["nombre"];
                $caso_descrip = $caso->atributos["descripcion"];
                $sel_status = $caso->atributos["status"];
                $sel_desp = $caso->atributos["id_Despacho"];
                $sel_cliente = $caso->atributos["id_Cliente"];
                $caso_id = $caso->atributos["id"];
               

                /* Status del Caso */
                if ($sel_status === 1) {
                    $caso_status = "Activo";
                } else {
                    $caso_status = "Inactivo";
                }
                /* Cargar despacho correspondiente */
                $desp = new Despacho();
                $exito2 = $desp->cargarDeBD("id", $sel_desp);
                if ($exito2) {

                    $caso_desp = $desp->atributos["nombre"];
                } else {
                    $caso_desp = "No encontrado";
                }

                /* Cargar Cliente correspondiente */
                $cliente = new Cliente();
                $exito3 = $cliente->cargarDeBD("id", $sel_cliente);
                if ($exito3) {
                    $caso_cliente = $cliente->atributos["nombre"];
                } else {
                    $caso_cliente = "No encontrado";
                }
            }
        }

        $caso_desp = $desp->atributos["nombre"];
        static::$smarty->assign('caso_nombre', $name);
        static::$smarty->assign('caso_descrip',$caso_descrip);
        static::$smarty->assign('caso_id',$caso_id);
        static::$smarty->assign('nombre', $accion . "Despachos");
        static::$smarty->assign('sel_status', $sel_status);
        static::$smarty->assign('sel_desp', $sel_desp);
        static::$smarty->assign('sel_cliente', $sel_cliente);

        static::$smarty->assign('caso_status', $caso_status);
        static::$smarty->assign('caso_desp', $caso_desp);
        static::$smarty->assign('caso_cliente', $caso_cliente);
        static::$smarty->assign('sel', $seleccion);
        static::$smarty->assign('name', "casos");
        static::$smarty->assign('tabla', "Casos");
        static::$smarty->assign('campo', "nombre");
        static::$smarty->assign('accion', $accion);
        /* Imprimir documento */
        static::$smarty->display($this->BASE_DIR . 'Vistas/Casos/' . $carpeta . '.tpl');
    }

    public function generarFormaInsercion() {


        if(isset($_REQUEST['nombre'])){
                $this->cargarDeBD("nombre", $_REQUEST['nombre']);
                $id = $this->atributos['id_Despacho'];
                $nombre = $this->atributos['nombre'];
                $caso_id = $this->atributos['id'];
                $this->procesa_insert(); //antes de pasar a la siguiente, guardo
                static::$smarty->assign('id_desp', $id);
                static::$smarty->assign('caso_name', $nombre);
                static::$smarty->assign('caso_id', $caso_id);
                static::$smarty->display($this->BASE_DIR . 'Vistas/Casos/AbogadosCasos.tpl');
        }else{
        static::$smarty->assign('accion', "Registrar");
        static::$smarty->assign('header', "Nuevo Caso");
        static::$smarty->display($this->BASE_DIR . 'Vistas/Casos/Altas.tpl');

        }
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
        $query = "SELECT id FROM " . static::$tabla_static . " WHERE " . $discriminante . " = '$valor' LIMIT 1";
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

    public function get_Expedientes() {

        $expedientes = array();
        $query = "SELECT * FROM " . Expediente::getNombreTabla() . " WHERE " . Expediente::getNombreTabla() . ".id_Caso =" . $this->atributos['id'];
        $resultado = $this->dbExecute($query);

        if ($resultado->num_rows) {
            while ($fila = $resultado->fetch_assoc()) {
                $aux = new Expediente();
                $aux->guardarDatos($fila);
                array_push($expedientes, $aux);
            }
        }
        return $expedientes;
    }

    public function generarFormaBorrado($seleccion, $nombre) {
        
    }

    public function validarDatos() {
        
    }

    public function procesa_insert() {

        foreach ($this->atributos as $campo => $valor) {
            if (isset($_REQUEST[$campo])) {
                $this->atributos[$campo] = $_REQUEST[$campo];
            }
        }
        if ($this->all_set()) {
            if ($this->almacenarEnBD()) {

                // Debug::getInstance()->alert("Registro Exitoso.");
            }
        }
    }
    
      public function service_delete($callback) {
        $json = array();
        $id = $this->atributos['id'];
        $query = "UPDATE $this->tabla SET visible = 0 WHERE id = $id";
       
        $resultado = $this->dbExecute($query);
        if ($resultado === true) {
            array_push($json, $this->atributos);
        }
        $finalData = array("Resultados" => $json);
        if ($callback != "") {
            $json = "$callback(" . json_encode($finalData) . ")";
        } else {
            $json = json_encode($finalData);
        }
        print_r($json);
        return $resultado;
    }

}
