<?php

/**
 * Description of Despacho
 *
 * @author José Luis Valencia Herrera     A01015544
 */
include_once './Clases/EntidadBD.php';
include_once './Clases/Direccion.php';

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
            case (1): //inserción
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
                    $this->atributos["visible"] = 1;
                    if ($this->almacenarEnBD())
                        Debug::getInstance()->alert("Registro Exitoso.");
                }
                break;
            case (2): //borrado
                $this->procesa_bajas();
                break;
            case (3): //actualizacion
                if ($_REQUEST['sel'] !== 0) {
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
                        $this->atributos["visible"] = 1;
                        if ($this->almacenarEnBD())
                            Debug::getInstance()->alert("Actualización Exitosa.");
                    }
                }
                break;
            default:
                break;
        }
    }

    public function generarFormaInsercion() {
        static::$smarty->display($this->BASE_DIR . 'Vistas/Despachos/Altas.tpl');
    }

    public function generarFormaActualizacion($seleccion, $nombre, $accion, $carpeta) {
        $name = "Selecciona";
        $calle = "Calle";
        $no_ext = "No.";
        $no_int = "No";
        $col = "Colonia";
        $cp = "cp";
        $cd = "Ciudad";
        $sel_mun = 0;
        $sel_edo = 0;

        /* Aqui cargamos el despacho */
        if ($nombre !== "Selecciona") {
            $desp = new Despacho();
            $exito = $desp->cargarDeBD("nombre", $nombre);
            if ($exito) {
                /* Actualizo el valor de name */
                $name = $desp->atributos["nombre"];
                /* Si el despacho existe, cargas su direccion */
                $dir = new Direccion();
                $exito2 = $dir->cargarDeBD("id", $desp->atributos['id_Direccion']);
                if ($exito2) {

                    $calle = $dir->atributos["calle"];
                    $cp = $dir->atributos["cp"];
                    $col = $dir->atributos["colonia"];
                    $no_ext = $dir->atributos["no_exterior"];
                    $no_int = $dir->atributos["no_interior"];
                    $cd = $dir->atributos["ciudad"];
                    $sel_mun = $dir->atributos["id_Municipio"];
                    /* Regreso nombre de municipio */
                    $mun = $dir->getMunicipio($sel_mun);
                    /* Uso el nombre para traer el id del edo */
                    $sel_edo = $dir->getIDEstadoDeMunicipio($mun);
                }
            }
        }
        static::$smarty->assign('nombre', $accion . "Despachos");
        static::$smarty->assign('desp_nombre', $name);
        static::$smarty->assign('desp_calle', $calle);
        static::$smarty->assign('desp_col', $col);
        static::$smarty->assign('desp_cp', $cp);
        static::$smarty->assign('desp_cd', $cd);
        static::$smarty->assign('desp_int', $no_int);
        static::$smarty->assign('desp_ext', $no_ext);
        static::$smarty->assign('sel_mun', $sel_mun);
        static::$smarty->assign('sel_edo', $sel_edo);

        static::$smarty->assign('sel', $seleccion);
        static::$smarty->assign('name', "despachos");
        static::$smarty->assign('tabla', "Despachos");
        static::$smarty->assign('campo', "nombre");
        static::$smarty->assign('accion', $accion);
        /* Imprimir documento */
        static::$smarty->display($this->BASE_DIR . 'Vistas/Despachos/' . $carpeta . '.tpl');
    }

    public function generarFormaBorrado($seleccion, $nombre) {
        
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
