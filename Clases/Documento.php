<?php

/**
 * Description of Documento
 *
 * @author José Luis Valencia Herrera     A01015544
 */
include_once 'EntidadBD.php';

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

    public function generarFormaActualizacion1($seleccion, $nombre, $accion, $carpeta) {
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
                /* Cargar Expediente */
                if ($exito2) {

                    $doc_exp = $exp->atributos["nombre"];
                } else {
                    $doc_exp = "No encontrado";
                }

                /* Cargar Tipo */
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

    public function generarFormaActualizacion($seleccion, $nombre, $accion, $carpeta) {
        /* Traer expediente en nombre???? */

        if ($seleccion === 0) { // cero es para ver los registros
            /* Recuperar todos los registros de la base de datos */
            $dbManager = DatabaseManager::getInstance();
            $dbManager->connectToDatabase();
            $query = "SELECT id,nombre FROM " . static::$tabla_static;
            $resultado = $dbManager->executeQuery($query);
            $dbManager->closeConnection();
            /* Arreglos de nombres y ids */
            $ids = array();

            if ($resultado->num_rows) {
                while ($fila = $resultado->fetch_assoc()) {
                    $ids[$fila['nombre']] = $fila['id'];
                }
            }


            static::$smarty->assign('nombre', $accion . "Documentos");
            static::$smarty->assign('name', "documentos");
            static::$smarty->assign('tabla', "Documentos");
            static::$smarty->assign('campo', "nombre");
            static::$smarty->assign('sel', $seleccion);
            static::$smarty->assign('ids', $ids);

            static::$smarty->display($this->BASE_DIR . 'Vistas/Documentos/' . $carpeta . '.tpl');
        } else { //traer el archivo seleccionado
            $dbManager = DatabaseManager::getInstance();
            $dbManager->connectToDatabase();
            $query = "SELECT documento,nombre,id_Tipo,tamano FROM " . static::$tabla_static . " WHERE id =" . $seleccion . " AND visible = 1";
            $resultado = $dbManager->executeQuery($query);
            $dbManager->closeConnection();

            if ($resultado != false) {
                if ($resultado->num_rows > 0) {
                    $row = $resultado->fetch_assoc();
                    if ($row['id_Tipo'] === 1) { //si es pdf
                        $tipo = "application/pdf";
                    } else {
                        $tipo = "application/pdf";  //solo de prueba, cambiar esto
                    }
                    $content = $row['documento'];
                    $nombre = $row['nombre'];
                    $tamano = $row['tamano'];
                } else {
                    Debug::getInstance()->alert("El archivo no se encuentra disponible.");
                }
            }

            header("Content-type: $tipo");
            header("Content-length: $tamano");
            while (@ob_end_clean());
            //header("Content-Disposition: attachment; filename=\"$nombre\"");
            echo $content;
        }
    }

    public function generarFormaBorrado($seleccion, $nombre) {
        
    }

    public function generarFormaInsercion() {

        static::$smarty->assign('accion', "Registrar");
        static::$smarty->assign('header', "Nuevo Documento");
        static::$smarty->display($this->BASE_DIR . 'Vistas/Documentos/Altas.tpl');
    }

    public function procesarForma($op) {
        switch ($op) {

            case 1: //alta 
                /* Procesa el archivo */
                if (isset($_FILES['documento']) && $_FILES['documento']['size'] > 0) {
                    //almacenamos la imagen en directorio temporal

                    $tmpName = $_FILES ['documento']['tmp_name'];
                    //Leemos el archivo
                    $fileSize = $_FILES['documento']['size'];
                    $fp = fopen($tmpName, 'r');
                    $data = fread($fp, filesize($tmpName));
                    $data = addslashes($data);
                    $this->atributos['documento'] = $data;
                    $this->atributos['tamano'] = $fileSize;
                    fclose($fp);
                } else {
                    Debug::getInstance()->alert("Falta documento");
                }
                /* Guarda el resto de los datos */
                foreach ($this->atributos as $campo => $valor) {
                    if (isset($_REQUEST[$campo])) {
                        if ($campo === "documento") {
                            $this->atributos['documento'] = $data;
                        } else {
                            $this->atributos[$campo] = $_REQUEST[$campo];
                        }
                    }
                }
                /* Corrobora que los demás atributos estén puestos */
                if ($this->all_set()) {
                    if ($this->almacenarEnBD()) {
                        Debug::getInstance()->alert("Registro Exitoso.");
                    }
                } else {
                    
                }
                break;
            case 2:
                $this->procesa_bajas();
                break;
            case 3: //sera el show de documentos
                //http://www.php-mysql-tutorial.com/wikis/mysql-tutorials/uploading-files-to-mysql-database.aspx
                // $this->procesa_cambios();
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

}
