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
            "visible" => 1);
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
        if (strlen($this->atributos['mail']) === 0 || strlen($this->atributos['mail']) > 30) {
            echo 'Longitud de usuario no valida';
            return false;
        } else {

            $query = "SELECT email FROM " . static::tabla_static . " WHERE email='" . $this->atributos['mail'] . "'";

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

    public function generarFormaActualizacion() {
        
    }

    public function generarFormaBorrado() {
        
    }

    public function generarFormaInsercion() {
        
    }

    public function procesarForma() {
        
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
