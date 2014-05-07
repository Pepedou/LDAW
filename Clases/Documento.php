<?php

/**
 * Description of Documento
 *
 * @author José Luis Valencia Herrera     A01015544
 */
include_once 'EntidadBD.php';
http://ubiquitous.csf.itesm.mx/~ldaw-1018566/content/Proyecto/Imagenes/default-mr.png
class Documento extends EntidadBD {

    static private $tabla_static = "Documentos";

    public function __construct() {
        parent::__construct();
        $this->tabla = static::$tabla_static;
        $this->atributos = array(
            "id" => -1,
            "nombre" => "",
            "documento" => "",
            "id_Expediente" => -1,
            "id_Tipo" => -1,
            "tamano" => 0,
            "visible" => 1);
        $this->discr = "id";
        $this->discrValor = $this->atributos[$this->discr];
    }

    public function generarFormaActualizacion($seleccion, $nombre, $accion, $carpeta) {
        /* Traer expediente en nombre???? */

        if ($seleccion === 0) { // cero es para ver los registros
            /* Recuperar todos los registros de la base de datos */
            $dbManager = DatabaseManager::getInstance();
            $dbManager->connectToDatabase();
            $query = "SELECT nombre,documento FROM " . static::$tabla_static;
            $resultado = $dbManager->executeQuery($query);
            $dbManager->closeConnection();
            /* Arreglos de nombres y ids */
            $ids = array();

            if ($resultado->num_rows) {
                while ($fila = $resultado->fetch_assoc()) {
                    $ids[$fila['nombre']] = $fila['documento'];
                }
            }

            static::$smarty->assign('nombre', $accion . "Documentos");
            static::$smarty->assign('name', "documentos");
            static::$smarty->assign('tabla', "Documentos");
            static::$smarty->assign('campo', "nombre");
            static::$smarty->assign('sel', $seleccion);
            static::$smarty->assign('ids', $ids);

            static::$smarty->display($this->BASE_DIR . 'Vistas/Documentos/' . $carpeta . '.tpl');
        } else {//Desplegar archivo
        }
    }

    public function generarFormaInsercion() {

        static::$smarty->assign('accion', "Registrar");
        static::$smarty->assign('header', "Nuevo Documento");
        static::$smarty->display($this->BASE_DIR . 'Vistas/Documentos/Altas.tpl');
    }

    public function procesarForma($op) {
        switch ($op) {

            case 1: //alta 
                $copiarArchivo = false;
                $extensiones = array("image/gif", "image/jpeg", "image/jpg",
                    "image/png", "application/pdf", "doc", "docx", "application/msword",
                    "application/vnd.ms-excel", "application/vnd.ms-powerpoint");
                /* Procesa el archivo */
                if (isset($_FILES['documento']) && $_FILES['documento']['size'] > 0) {

                    $nombreDirectorio = "http://ubiquitous.csf.itesm.mx/~ldaw-1018566/content/Proyecto/Documentos/";
                    $idUnico = time();
                    $nombreArchivo = $idUnico . "-" . $_FILES['documento']['name'];
                    $this->atributos['documento'] = $nombreDirectorio . $nombreArchivo;
                    $this->atributos['tamano'] = $_FILES['documento']['size'];
                    $tmpName = $_FILES ['documento']['tmp_name'];
                    $copiarArchivo = true;
                } else {
                    $nombreArchivo = '';
                    // Debug::getInstance()->alert("Falta documento");
                }
                /* Guarda el resto de los datos */
                foreach ($this->atributos as $campo => $valor) {
                    if (isset($_REQUEST[$campo])) {
                        if ($campo === "documento") {
                            $this->atributos['documento'] = $nombreDirectorio . $nombreArchivo;
                        } else {
                            $this->atributos[$campo] = $_REQUEST[$campo];
                        }
                    }
                }

                /* Mover archivo de imagen a su ubicación definitiva */
                if ($copiarArchivo) {

                    $tipo = $_FILES['documento']['type'];
                    if (in_array($tipo, $extensiones)) { //si la extensión es permitida

                        /* Corrobora que los demás atributos estén puestos */
                        if ($this->all_set()) {
                            if ($this->almacenarEnBD()) { //si el registro es exitoso, muevo el archivo
                                $tmpName = $_FILES ['documento']['tmp_name'];
                                if (move_uploaded_file($tmpName, "Documentos/" . $nombreArchivo)) {
                                    //  Debug::getInstance()->alert("Archivo Movido");
                                } else {
                                    // Debug::getInstance()->alert("Archivo No Movido");
                                }
                                Debug::getInstance()->alert("Registro Exitoso.");
                            }
                        } else {
                            Debug::getInstance()->alert("Error en el Registro.");
                        }
                    } else {
                        Debug::getInstance()->alert("Tipo de Archivo no permitido");
                    }
                }
                break;
            case 2:
                $this->procesa_bajas();
                break;
            case 3: //sera el show de documentos

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

    public function all_set() {
        $count = 0;
        $att_count = count($this->atributos) - 4; //menos id, tamano,documento y visible

        foreach ($this->atributos as $campo => $valor) {
            if ($campo != 'id' && $campo != 'documento' && $campo != 'visible') {

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

    public function generarFormaBorrado($seleccion, $nombre) {
        
    }

    public function validarDatos() {
        
    }

}
