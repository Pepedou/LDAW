<?php

/**
 * Description of Despacho
 *
 * @author José Luis Valencia Herrera     A01015544
 */
include_once './EntidadBD.php';

class Despacho extends EntidadBD {

    static private $tabla_static = "Despachos";

    public function __construct() {
        parent::__construct();
        $this->tabla = static::$tabla_static;
        $this->atributos = array(
            "id" => -1,
            "nombre" => "NULL",
            "id_Direccion" => -1,
            "visible" => 1);
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

    public function procesarForma() {
        if (isset($_REQUEST['nombre'], $_REQUEST['id_Direccion'])) {
            $this->atributos['nombre'] = $_REQUEST['nombre'];
            $this->atributos['id_Direccion'] = $_REQUEST['id_Direccion'];
            Debug::getInstance()->alert("Despacho nuevo: " . $this->atributos['nombre']);
            return true;
        } else {
            return false;
        }
    }

    public function generarFormaInsercion() {
        print
                "<form action='altas.php' method='get'>
            <table>            
                <tr>
                    <td>
                        <p>Nombre del despacho</p>
                    </td>
                    <td>
                        <input type='text' name='nombre' />
                    </td>
                </tr>
                <tr>
                    <td>
                        <p>Dirección del despacho</p>
                    </td>
                    <td>
                        <input type='text' name='id_Direccion' />
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type='submit' value='Aceptar' />
                    </td>
                </tr>
            </table>
         </form>
        ";
    }

    public function generarFormaActualizacion() {
        
    }

    public function generarFormaBorrado() {
        $dbM = $this->dbManager;
        $dbM->connectToDatabase();
        $query = "Select id,nombre FROM " . static::$tabla_static;
        $resultado = $dbM->executeQuery($query);
        print
                "<select>";
        while ($row = $resultado->fetch_assoc()) {
            print
                    "<option value=" . $row['id'] . ">" . $row['nombre'] . "</option>";
        }
        print
                "</select>";
        $dbM->closeConnection();
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
