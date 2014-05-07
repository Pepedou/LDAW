<?php

include_once 'EntidadBD.php';
include_once 'Despacho.php';
include_once 'Rol.php';

class Abogado extends EntidadBD {

    static private $tabla_static = "Abogados";

    public function __construct() {
        parent::__construct();
        $this->tabla = static::$tabla_static;
        $this->atributos = array(
            "id" => -1,
            "nombre" => "",
            "apellidoP" => "",
            "apellidoM" => "",            
            "telefono" => 0,
            "email" => "",
            "contrasena" => "",
            "id_Rol" => -1,
            "id_Despacho" => -1,
            "visible" => 1,
            "fotografia" => "http://ubiquitous.csf.itesm.mx/~ldaw-1018566/content/Proyecto/Imagenes/default-mr.png"
            );
        $this->discr = "email";
        $this->discrValor = $this->atributos[$this->discr];
    }

    public function cargarDespacho() {
        $despacho = new Despacho();

        $query = "SELECT * FROM " . Despacho::getNombreTabla() . " WHERE id=" . $this->atributos['id_Despacho'];
        $resultado = $this->dbExecute($query);
        Debug::getInstance()->alert($query);

        if ($resultado != false && $resultado->num_rows) {
            $fila = $resultado->fetch_assoc();
            $despacho->guardarDatos($fila);
        }
        return $despacho;
    }

    public function getRol() {
        $rol = array();
        $query = "SELECT rol FROM " . Rol::getNombreTabla() . " WHERE id = " . $this->atributos['id_Rol'] . " LIMIT 1";
        $resultado = $this->dbExecute($query);

        if ($resultado->num_rows) {
            foreach ($resultado->fetch_assoc() as $tupla) {
                array_push($rol, $tupla);
            }
        }
        return $rol;
    }

    public function verificaLogin(array $datos, $callback) {
        $email = $datos['email'];
        $pwd = $datos['contrasena'];
        $data = array();
        $query = "SELECT email FROM " . static::$tabla_static . " WHERE email = '$email' AND contrasena = '" . sha1($pwd) . "' LIMIT 1";
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

    public function verificaUsuario() {
        if (strlen($this->atributos['email']) === 0 || strlen($this->atributos['email']) > 30) {
            echo 'Longitud de usuario no valida';
            return false;
        } else {

            $query = "SELECT email FROM " . static::tabla_static . " WHERE email='" . $this->atributos['email'] . "'";

            $resultado = $this->dbExecute($query);

            if (($resultado->num_rows)) {
                return false;
            } else {
                return true; //sí esta libre para usarse
            }
        }
    }

    public function guardarDatos(array $misDatos) {
        foreach ($misDatos as $campo => $valor) {
            if ($campo === "contrasena" && $this->existente != false) {
                $this->atributos[$campo] = sha1($misDatos[$campo]);
            } else {
                $this->atributos[$campo] = $misDatos[$campo];
            }
        }
        $this->actualizarValorDiscr();
    }

    public function generarFormaActualizacion($seleccion, $nombre, $accion, $carpeta) {
        $name = "Selecciona";
        $apellido_p = "Apellido Paterno";
        $apellido_m = "Apellido Materno";
        $telefono = "Tel.";
        $email = "Email";
        $foto = $this->atributos['fotografia'];
        $sel_rol = 0;
        $sel_desp = 0;

        if ($nombre !== "Selecciona") {
            $abo = new Abogado();
            $exito = $abo->cargarDeBD("nombre", $nombre);
            if ($exito) {

                /* Actualizo valores*/
                $name = $abo->atributos["nombre"];
                $apellido_p = $abo->atributos["apellidoP"];
                $apellido_m = $abo->atributos["apellidoM"];
                $telefono = $abo->atributos["telefono"];
                $email = $abo->atributos["email"];
                $sel_rol = $abo->atributos["id_Rol"];
                $sel_desp = $abo->atributos["id_Despacho"];
                $foto = $abo->atributos['fotografia'];
                /* Cargamos Despacho */
                $desp = new Despacho();
                $exito2 = $desp->cargarDeBD("id", $sel_desp);
                if ($exito2) {

                    $abog_desp = $desp->atributos["nombre"];
                } else {
                    $abog_desp = "No encontrado";
                }
                /* Cargamos Rol */
                $rol = new Rol();
                $exito3 = $rol->cargarDeBD("id", $sel_rol);
                if ($exito3)
                    $abog_rol = $rol->atributos["rol"];
            } else {
                $abog_rol = "No encontrado";
            }
        }
        static::$smarty->assign('nombre', $accion . "Despachos");
        static::$smarty->assign('abog_nombre', $name);
        static::$smarty->assign('abog_apep', $apellido_p);
        static::$smarty->assign('abog_apem', $apellido_m);
        static::$smarty->assign('abog_tel', $telefono);
        static::$smarty->assign('abog_email', $email);
        static::$smarty->assign('abog_rol', $abog_rol);
        static::$smarty->assign('abog_desp', $abog_desp);
        static::$smarty->assign('sel_rol', $sel_rol);
        static::$smarty->assign('sel_desp', $sel_desp);
        static::$smarty->assign('foto', $foto);

        static::$smarty->assign('select_rol', $sel_rol);
        static::$smarty->assign('select_desp', $sel_desp);
        static::$smarty->assign('sel', $seleccion);
        static::$smarty->assign('name', "abogados");
        static::$smarty->assign('tabla', "Abogados");
        static::$smarty->assign('campo', "nombre");
        static::$smarty->assign('accion', $accion);
        /* Imprimir documento */
        static::$smarty->display($this->BASE_DIR . 'Vistas/Abogados/' . $carpeta . '.tpl');
    }

    public function generarFormaInsercion() {
        static::$smarty->assign('nombre', "Nuevo Abogado");
        static::$smarty->assign('accion', "Registrar");
        static::$smarty->assign('header', "Alta de Abogados");
        static::$smarty->assign('foto', $this->atributos['fotografia']);
        static::$smarty->display($this->BASE_DIR . 'Vistas/Abogados/Altas_2.tpl');
    }

    public function procesarForma($op) {
        switch ($op) {
            case 1: //alta    

                $copiarArchivo = false;
                $extensiones = array("image/gif", "image/jpeg", "image/jpg",
                    "image/png");
                /* Procesa el archivo */
                if (isset($_FILES['fotografia']) && $_FILES['fotografia']['size'] > 0) {

                    $nombreDirectorio = "http://ubiquitous.csf.itesm.mx/~ldaw-1018566/content/Proyecto/Imagenes/";
                    $idUnico = time();
                    $nombreArchivo = $idUnico . "-" . $_FILES['fotografia']['name'];
                    $this->atributos['fotografia'] = $nombreDirectorio . $nombreArchivo;
                    $tmpName = $_FILES ['fotografia']['tmp_name'];
                    $copiarArchivo = true;
                } else {
                    $nombreArchivo = '';
                }

                foreach ($this->atributos as $campo => $valor) {
                    if (isset($_REQUEST[$campo])) {
                        if ($campo === "contrasena") {
                            $this->atributos[$campo] = sha1($_REQUEST[$campo]);
                        } else {
                            $this->atributos[$campo] = $_REQUEST[$campo];
                        }
                    }
                }

                /* Mover archivo de imagen a su ubicación definitiva */
                if ($copiarArchivo) {

                    $tipo = $_FILES['fotografia']['type'];
                    if (in_array($tipo, $extensiones)) { //si la extensión es permitida
                        $tmpName = $_FILES ['fotografia']['tmp_name'];
                        if (move_uploaded_file($tmpName, "Imagenes/" . $nombreArchivo)) {
                            //  Debug::getInstance()->alert("Archivo Movido");
                        } else {
                            // Debug::getInstance()->alert("Archivo No Movido");
                        }
                    } else {
                        Debug::getInstance()->alert("Tipo de Archivo no permitido");
                    }
                }
                /* Corrobora que los demás atributos estén puestos */
                if ($this->all_set()) {
                    if ($this->almacenarEnBD()) { //si el registro es exitoso, muevo el archivo
                        Debug::getInstance()->alert("Registro Exitoso.");
                    } else {
                        Debug::getInstance()->alert("Error en el Registro.");
                    }
                }

                break;
            case 2: //bajas
                if (isset($_REQUEST['nombre']) && isset($_REQUEST['elim'])) {
                    $this->atributos["id"] = $this->getID("nombre", $_REQUEST['nombre']);

                    if ($this->eliminarDeBD())
                        Debug::getInstance()->alert("Registro Eliminado.");
                }

                break;
            case 3: //cambios

                if ($_REQUEST['sel'] !== 0) {

                    foreach ($this->atributos as $campo => $valor) {
                        if (isset($_REQUEST[$campo])) {
                            $this->atributos[$campo] = $_REQUEST[$campo];
                        }
                    }
                    if ($this->all_set()) {
                        if ($this->almacenarEnBD()) {
                            Debug::getInstance()->alert("Actualización Exitosa.");
                        } else {
                            Debug::getInstance()->alert("Actualización Errónea.");
                        }
                    }
                }

                break;
                http://ubiquitous.csf.itesm.mx/~ldaw-1018566/content/Proyecto/Imagenes/default-mr.png
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
                http://ubiquitous.csf.itesm.mx/~ldaw-1018566/content/Proyecto/Imagenes/default-mr.png
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

    public function all_set() {
        $count = 0;
        $att_count = count($this->atributos) - 4; //menos id, constraseña , foto y visible

        foreach ($this->atributos as $campo => $valor) {
            if ($campo != 'id' && $campo != 'contrasena' && $campo != 'visible') {

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
