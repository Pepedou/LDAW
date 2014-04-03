<?php

include_once './ServicioGenerico.php';

/**
 * Description of EntidadBD
 *
 * @author José Luis Valencia Herrera     A01015544
 */
abstract class EntidadBD extends ServicioGenerico {

    protected $debug, $dbManager, $existente;

    public function __construct() {
        $this->debug = Debug::getInstance();
        $this->dbManager = DatabaseManager::getInstance();
        $this->existente = false;
    }

    abstract static public function getID($discriminante, $valor);

    abstract static public function getID_MultDiscr(array $arregloDiscrValor);

    abstract static public function getNombreTabla();

    public function revisarExistencia($discriminante, $valor) {
        $query = "SELECT id FROM $this->tabla WHERE $discriminante = '$valor' LIMIT 1";
        $resultado = $this->dbExecute($query);
        if ($resultado != false) {
            if ($resultado->num_rows > 0) {
                $this->existente = true;
                return true;
            } else {
                $this->existente = false;
                return false;
            }
        } else {
            $this->debug->alert("EntidadBD::revisarExistencia => Error en la consulta " . $query);
            return false;
        }
    }

    public function revisarExistencia_MultDiscr(array $arregloDiscrValor) {
        foreach ($arregloDiscrValor as $campo => $valor) {
            if ($campo != 'id') {
                $condicion .= "$campo = '$valor' AND ";
            }
        }
        $condicion = preg_replace('/\W\w+\s*(\W*)$/', '$1', $condicion); //Elimina el último AND

        $query = "SELECT id FROM $this->tabla WHERE $condicion LIMIT 1";
        $resultado = $this->dbExecute($query);
        if ($resultado != false) {
            if ($resultado->num_rows) {
                $this->existente = true;
                return true;
            } else {
                $this->existente = false;
                return false;
            }
        } else {
            $this->debug->alert("EntidadBD::revisarExistencia_MultDiscr => Error en la consulta " . $query);
            $this->existente = false;
            return false;
        }
    }

    public function cargarDeBD($discriminante, $valor) {
        if ($discriminante === 'id' && $valor === -1) {//Si se busca por ID, hay que usar todos
            if ($this->cargarDeBD_MultDiscr($this->atributos)) {//Si encuentra el miembro
                $this->discrValor = $this->atributos['id']; //Pongo el valor del ID como discriminante
                return true;
            } else {
                return false;
            }
        }
        $query = "SELECT * FROM $this->tabla WHERE $discriminante = '$valor' LIMIT 1";
        $resultado = $this->dbExecute($query);
        if ($resultado != false && $resultado->num_rows) {
            foreach ($resultado->fetch_assoc() as $campo => $valor) {
                $this->atributos[$campo] = $valor;
            }
            $this->existente = true;
            $this->actualizarValorDiscr();
            return true;
        } else {
            Debug::getInstance()->alert("EntidadBD::cargarDeBD => No se pudo cargar.");
            $this->existente = false;
            return false;
        }
    }

    public function cargarDeBD_MultDiscr(array $arregloDiscrValor) {
        foreach ($arregloDiscrValor as $campo => $valor) {
            if ($campo != 'id') {
                $condicion .= "$campo = '$valor' AND ";
            }
        }
        $condicion = preg_replace('/\W\w+\s*(\W*)$/', '$1', $condicion); //Elimina el último AND
        $query = "SELECT * FROM $this->tabla WHERE $condicion LIMIT 1";
        $resultado = $this->dbExecute($query);
        if ($resultado != false && $resultado->num_rows) {
            foreach ($resultado->fetch_assoc() as $campo => $valor) {
                $this->atributos[$campo] = $valor;
            }
            $this->existente = true;
            return true;
        } else {
            Debug::getInstance()->alert("EntidadBD::cargarDeBD_MultDiscr => No se pudo cargar.");
            $this->existente = false;
            return false;
        }
    }

    public function almacenarEnBD() {
        $this->actualizarValorDiscr(); //Me aseguro de que el discriminante tenga el valor correcto
        if ($this->discr === 'id' && $this->discrValor === -1) {//Si se busca por id y no se ha cargado el objeto
            $this->revisarExistencia_MultDiscr($this->atributos);
        } else {
            $this->revisarExistencia($this->discr, $this->discrValor);
        }
        if (!$this->existente) {//Reviso si ya existe, si no, lo creo
            foreach ($this->atributos as $campo => $campoValor) {//Genero string de campos y valores
                if ($campo != "id") {
                    $subqueryCamps .= $campo . ",";
                    $subqueryVals .= "'" . $campoValor . "',";
                }
            }
            $subqueryCamps = rtrim($subqueryCamps, ","); //Elimina la última coma
            $subqueryVals = rtrim($subqueryVals, ","); //Elimina la última coma

            $query = "INSERT INTO $this->tabla ($subqueryCamps) VALUES ($subqueryVals)";
            $resultado = $this->dbExecute($query);
            if ($resultado != false) {
                $this->existente = true;
                $this->cargarDeBD($this->discr, $this->atributos[$this->discr]);
                return true;
            } else {
                Debug::getInstance()->alert("EntidadBD::almacenarEnBD => No se pudo insertar.");
                return false;
            }
        } else {//Si ya existe, actualizo los valores 
            /* Obtengo el ID real, es importante que el valor del discriminante
             * sea el mismo que tenía originalmente mediante $this->actualizarValorDiscr();
             */
            $this->atributos['id'] = static::getID($this->discr, $this->discrValor);

            foreach ($this->atributos as $campo => $valor) {//Creo asignaciones SQL
                if ($campo != "id") {
                    $subquerySets .= $campo . "='" . $valor . "',";
                }
            }
            $subquerySets = rtrim($subquerySets, ","); //Elimina la última coma

            $query = "UPDATE $this->tabla SET $subquerySets WHERE id = '" . $this->atributos['id'] . "'";
            $resultado = $this->dbExecute($query);
            if ($resultado === true) {
                $this->actualizarValorDiscr();
                return true;
            } else {
                Debug::getInstance()->alert("EntidadBD::almacenarEnBD => No se pudo actualizar.");
                return false;
            }
        }
    }

    public function eliminarDeBD() {
        $query = "UPDATE $this->tabla SET visible = 0 WHERE id = '" . $this->atributos['id'] . "'";
        $resultado = $this->dbExecute($query);
        if ($resultado === true) {
            return true;
        } else {
            Debug::getInstance()->alert("EntidadBD::eliminarDeBD => No se pudo eliminar.");
            return false;
        }
    }

    public function printData() {
        print_r($this->atributos);
    }

    abstract public function generarFormaInsercion();

    abstract public function generarFormaActualizacion();

    abstract public function generarFormaBorrado();

    abstract public function procesarForma();

    public function guardarDatos(array $misDatos) {
        foreach ($misDatos as $campo => $valor) {
            $this->atributos[$campo] = $misDatos[$campo];
        }
        $this->actualizarValorDiscr();
    }

    protected function actualizarValorDiscr() {
        /*Si el discriminante es ID, tengo que ver si necesito cargar el id de la base de datos.
         * Esto lo determino si tanto el valor del discriminante como el atributo id son los default.
         */
        if ($this->discr === 'id' && $this->discrValor === -1 && $this->atributos['id'] == -1) {
            $this->atributos['id'] = static::getID_MultDiscr($this->atributos);
        }
        $this->discrValor = $this->atributos[$this->discr];
    }

    abstract public function validarDatos();
}
