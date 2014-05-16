<?php

/**
 * Description of Cliente
 *
 * @author José Luis Valencia Herrera     A01015544
 */
include_once 'EntidadBD.php';
include_once 'Direccion.php';

class Cliente extends EntidadBD {

    static private $tabla_static = "Clientes";

    public function __construct() {
        parent::__construct();
        $this->tabla = static::$tabla_static;
        $this->atributos = array(
            "id" => -1,
            "nombre" => "NULL",
            "apellidoP" => "NULL",
            "apellidoM" => "NULL",
            "id_Direccion" => -1,
            "telefono" => 0,
            "email" => "NULL",
            "contrasena" => "",
            "visible" => 1);
        $this->discr = "email";
        $this->discrValor = $this->atributos[$this->discr];
    }

    public function cargarDireccion() {
        $direccion = new Direccion();
        $query = "SELECT * FROM " . Direccion::getNombreTabla() . " WHERE id=" . $this->atributos['id_Direccion'] . " LIMIT 1";
        $resultado = $this->dbExecute($query);

        if ($resultado->num_rows) {
            $fila = $resultado->fetch_assoc();
            $direccion->guardarDatos($fila);
        }

        return $direccion;
    }

    public function guardarDatos(array $misDatos) {
        foreach ($this->atributos as $campo => $valor) {
            if ($campo === "contrasena") {
                $this->atributos[$campo] = sha1($misDatos[$campo]);
            } else {
                $this->atributos[$campo] = $misDatos[$campo];
            }
        }
        $this->actualizarValorDiscr();
    }

    /* Funcion para generar servicio con los pagos correspondientes al cliente */

    public function cargarPagos(array $datos, $callback) {
        $id = $datos['id'];
        $json = array();
        $query = "SELECT * FROM " . Pago::getNombreTabla() . " WHERE id_Cliente = " . $id;
        $resultado = $this->dbExecute($query);
        /* Genero el JSON con los resultados */
        if ($resultado != false) {
            while ($fila = $resultado->fetch_assoc()) {
                array_push($json, $fila);
            }
            $finalData = array("Resultados" => $json);
            if ($callback != "") {
                $json = "$callback(" . json_encode($finalData) . ")";
            } else {
                $json = json_encode($finalData);
            }
            print_r($json);
        }
        return $json;
    }

    /* Funcion para generar servicio con los pagos correspondientes al cliente */

    public function servicioCasos(array $datos, $callback) {
        $id = $datos['id'];
        $json = array();
        $query = "SELECT * FROM " . Caso::getNombreTabla() . " WHERE " . Caso::getNombreTabla() . ".id_Cliente =" . $datos['id'];
        $resultado = $this->dbExecute($query);
        /* Genero el JSON con los resultados */
        if ($resultado != false) {
            while ($fila = $resultado->fetch_assoc()) {
                array_push($json, $fila);
            }
            $finalData = array("Resultados" => $json);
            if ($callback != "") {
                $json = "$callback(" . json_encode($finalData) . ")";
            } else {
                $json = json_encode($finalData);
            }
            print_r($json);
        }
        return $json;
    }

    public function service_update($callback) {
        $json = array();
        foreach ($this->atributos as $campo => $campoValor) {
            if ($campo != "id") {
                if ($campo == "contrasena")
                    $subquerySets .= $campo .= "= SHA1('" . $campoValor . "')";
                else
                    $subquerySets .= $campo . "='" . $campoValor . "',";
            }
        }
        $subquerySets = rtrim($subquerySets, ","); //Elimina la última coma

        $query = "UPDATE $this->tabla SET $subquerySets WHERE $this->discr = '$this->discrValor'";
        $resultado = $this->dbExecute($query);
        if ($resultado === true) {
            array_push($json, $this->atributos);
            $finalData = array("Resultados" => $json);
            if ($callback != "") {
                $json = "$callback(" . json_encode($finalData) . ")";
            } else {
                $json = json_encode($finalData);
            }
            print_r($json);
        } else {
            print "[null]";
        }
        return $resultado;
    }

    public function verificaLogin(array $datos, $callback) {
        $email = $datos['email'];
        $pwd = $datos['contrasena']; //necesitamos añadir contraseña al cliente
        $data = array();
        $query = "SELECT email FROM " . static::$tabla_static . " WHERE email = '$email' LIMIT 1";
        $resultado = $this->dbExecute($query);
        if ($resultado != false) {
            $row = $resultado->fetch_assoc();
            $data[] = array("email" => $row['email']);
        } else {
            $data[] = array("email" => "NULL");
        }
        $finalData = array("Resultados" => $data);
        if ($callback != "") {
            $json = "$callback(" . json_encode($finalData) . ")";
        } else {
            $json = json_encode($finalData);
        }
        print_r($json);
    }

    public function generarFormaActualizacion($seleccion, $nombre, $accion, $carpeta) {
        $name = "Selecciona";
        $apellido_p = "Apellido Paterno";
        $apellido_m = "Apellido Materno";
        $telefono = "Tel.";
        $email = "Email";
        $contrasena = "";
        $sel_mun = 0;
        $sel_edo = 0;


        if ($nombre !== "Selecciona") {
            $cliente = new Cliente();
            $exito = $cliente->cargarDeBD("nombre", $nombre);
            if ($exito) {

                /* Actualizo valores del cliente */
                $name = $cliente->atributos["nombre"];
                $apellido_p = $cliente->atributos["apellidoP"];
                $apellido_m = $cliente->atributos["apellidoM"];
                $telefono = $cliente->atributos["telefono"];
                $email = $cliente->atributos["email"];

                /* Cargo la direccion */
                $dir = new Direccion();
                $exito2 = $dir->cargarDeBD("id", $cliente->atributos['id_Direccion']);
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
        static::$smarty->assign('cliente_nombre', $name);
        static::$smarty->assign('cliente_apep', $apellido_p);
        static::$smarty->assign('cliente_apem', $apellido_m);
        static::$smarty->assign('cliente_tel', $telefono);
        static::$smarty->assign('cliente_email', $email);

        static::$smarty->assign('cliente_calle', $calle);
        static::$smarty->assign('cliente_col', $col);
        static::$smarty->assign('cliente_cp', $cp);
        static::$smarty->assign('cliente_cd', $cd);
        static::$smarty->assign('cliente_int', $no_int);
        static::$smarty->assign('cliente_ext', $no_ext);
        static::$smarty->assign('sel_mun', $sel_mun);
        static::$smarty->assign('sel_edo', $sel_edo);

        static::$smarty->assign('sel', $seleccion);
        static::$smarty->assign('name', "clientes");
        static::$smarty->assign('tabla', "Clientes");
        static::$smarty->assign('campo', "nombre");
        static::$smarty->assign('accion', $accion);
        /* Imprimir documento */
        static::$smarty->display($this->BASE_DIR . 'Vistas/Clientes/' . $carpeta . '.tpl');
    }

    public function generarFormaInsercion() {

        static::$smarty->assign('nombre', "Nuevo Cliente");
        static::$smarty->assign('accion', "Registrar");
        static::$smarty->assign('header', "Alta de Clientes");

        static::$smarty->display($this->BASE_DIR . 'Vistas/Clientes/Altas.tpl');
    }

    public function procesarForma($op) {
        switch ($op) {
            case 1:
                $dir = new Direccion();
                foreach ($this->atributos as $campo => $valor) {

                    if (isset($_REQUEST[$campo])) {
                        if ($campo === "contrasena") {
                            $this->atributos[$campo] = sha1($_REQUEST[$campo]);
                        } else {
                            $this->atributos[$campo] = $_REQUEST[$campo];
                        }
                    }
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
            case 2:
                $this->procesa_bajas();
                break;
            case 3:
                if ($_REQUEST['sel'] !== 0) {
                    $dir = new Direccion();
                    foreach ($this->atributos as $campo => $valor) {

                        $this->atributos[$campo] = $_REQUEST[$campo];
                    }
                    $this->atributos["visible"] = 1;
                    foreach ($dir->atributos as $campo => $valor) {
                        $dir->atributos[$campo] = $_REQUEST[$campo]; //guarda los atributos para la direccion              
                    }
                    if ($dir->atributos["calle"] != NULL) {
                        $dir->almacenarEnBD();
                        $id = $dir->getID("calle", $dir->atributos["calle"]);
                        $this->atributos["id_Direccion"] = $id;
                        if ($this->almacenarEnBD())
                            Debug::getInstance()->alert("Actualización Exitosa.");
                    }
                }
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

    public function cargarCasos() {
        $casos = array();

        $query = "SELECT * FROM " . Caso::getNombreTabla() . " WHERE " . Caso::getNombreTabla() . ".id_Cliente =" . $this->atributos['id'];

        $resultado = $this->dbExecute($query);

        if ($resultado->num_rows) {
            while ($fila = $resultado->fetch_assoc()) {
                $aux = new Caso();
                $aux->guardarDatos($fila);
                array_push($casos, $aux);
            }
        }

        return $casos;
    }

    public static function getNombreTabla() {
        return static::$tabla_static;
    }

    public function generarFormaBorrado($seleccion, $nombre) {
        
    }

    public function validarDatos() {
        
    }

}
