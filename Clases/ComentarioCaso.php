<?php

/**
 * Description of ComentarioCaso
 *
 * @author José Luis Valencia Herrera     A01015544
 */
include_once './Abogado.php';
include_once './Caso.php';

class ComentarioCaso extends EntidadBD {

    static private $tabla_static = "ComentariosCaso";

    public function __construct() {
        parent::__construct();
        $this->tabla = static::$tabla_static;
        $this->atributos = array(
            "id" => -1,
            "comentario" => "",
            "id_Abogado" => -1,
            "id_Caso" => -1,
            "visible" => 1
        );
        $this->discr = "id";
        $this->discrValor = $this->atributos[$this->discr];
    }

    public function cargarCaso() {
        $caso = new Caso();

        $query = "SELECT * FROM " . Caso::getNombreTabla() . " WHERE id=" . $this->atributos['id_Caso'];
        $resultado = $this->dbExecute($query);
        Debug::getInstance()->alert($query);

        if ($resultado != false && $resultado->num_rows) {
            $fila = $resultado->fetch_assoc();
            $caso->guardarDatos($fila);
        }
        return $caso;
    }

    public function cargarAbogado() {
        $abogado = new Abogado();

        $query = "SELECT * FROM " . Abogado::getNombreTabla() . " WHERE id=" . $this->atributos['id_Abogado'];
        $resultado = $this->dbExecute($query);
        Debug::getInstance()->alert($query);

        if ($resultado != false && $resultado->num_rows) {
            $fila = $resultado->fetch_assoc();
            $abogado->guardarDatos($fila);
        }
        return $abogado;
    }

    public function generarFormaActualizacion($seleccion, $nombre, $accion, $carpeta) {
        
    }

    public function generarFormaBorrado($seleccion, $nombre) {
        
    }

    public function generarFormaInsercion() {
        
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
