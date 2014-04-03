<?php

/**
 * Description of Documento
 *
 * @author José Luis Valencia Herrera     A01015544
 */
include_once './EntidadBD.php';

class Documento extends EntidadBD {

    static private $tabla_static = "Documentos";

    public function __construct() {
        parent::__construct();
        $this->tabla = static::$tabla_static;
        $this->atributos = array(
            "id" => -1,
            "nombre"=>"",
            "documento" => "",
            "id_Expediente" => -1,
            "id_Tipo" => -1,
            "visible" => 1);
        $this->discr = "id";
        $this->discrValor = $this->atributos[$this->discr];
    }

    public function generarFormaActualizacion($seleccion, $nombre, $accion, $carpeta) {
        $name = "Selecciona";
        $sel_exp = 0;
        $sel_tipo = 0;

        if ($nombre !== "Selecciona") {
            $doc = new Documento();
            $exito = $doc->cargarDeBD("nombre", $nombre);
            if ($exito) {
                /* Actualizo el valor de name */
                $name = $doc->atributos["nombre"];
                $sel_exp = $doc->atributos["id_Expediente"];
                $sel_tipo = $doc->atributos["id_Tipo"];
                
                $exp = new Expediente();
                $exito2 = $exp->cargarDeBD("id", $sel_exp);
                /*Cargar Expediente*/
                if ($exito2) {
                   
                    $doc_exp = $exp->atributos["nombre"];
                   
                } else {
                    $doc_exp = "No encontrado";
                   
                }
                
                /*Cargar Tipo*/
                $tipo = new Tipo();
                $exito3 = $tipo->cargarDeBD("id", $sel_tipo);
               
                if ($exito3) {
                   
                    $doc_tipo = $exp->atributos["tipo"];
                   
                } else {
                    $doc_tipo = "No encontrado";
                   
                }
            }
        }
        
         
        static::$smarty->assign('doc_nombre', $name);
        static::$smarty->assign('nombre', $accion . "Documentos");
        static::$smarty->assign('select_exp', $sel_exp);
        static::$smarty->assign('select_tipo', $sel_tipo);
        static::$smarty->assign('doc_exp', $doc_exp);
        static::$smarty->assign('doc_tipo', $doc_tipo);
        static::$smarty->assign('sel', $seleccion);
        static::$smarty->assign('name', "documentos");
        static::$smarty->assign('tabla', "Documentos");
        static::$smarty->assign('campo', "nombre");
        static::$smarty->assign('accion', $accion);
        /* Imprimir documento */
        static::$smarty->display($this->BASE_DIR . 'Vistas/Documentos/' . $carpeta . '.tpl');
    }

    public function generarFormaBorrado($seleccion, $nombre) {
        
    }

    public function generarFormaInsercion() {

        static::$smarty->assign('accion', "Registrar");
        static::$smarty->assign('header', "Nuevo Documento");
        static::$smarty->display($this->BASE_DIR . 'Vistas/Documentos/Altas.tpl');
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
