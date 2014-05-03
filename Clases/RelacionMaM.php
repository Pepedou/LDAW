<?php

/**
* Description of RelacionMaM
*
* @author José Luis Valencia Herrera A01015544
*/
include_once './Clases/ServicioGenerico.php';

abstract class RelacionMaM extends ServicioGenerico {

    protected $debug, $dbManager, $existente;

    public function __construct() {
        $this->debug = Debug::getInstance();
        $this->dbManager = DatabaseManager::getInstance();
        $this->existente = false;
    }

    abstract static public function getNombreTabla();

    public function revisarExistencia() {
        foreach ($this->atributos as $campo => $campoValor) {
            $condiciones .= $campo . "=" . $campoValor . " AND ";
        }
        $condiciones = preg_replace('/\W\w+\s*(\W*)$/', '$1', $condiciones);
        $query = "SELECT * FROM $this->tabla WHERE $condiciones LIMIT 1";
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
            $this->debug->alert("RelacionMaM::revisarExistencia => Error en la consulta " . $query);
            return false;
        }
    }

    public function almacenarEnBD() {
        $this->revisarExistencia();
        if (!$this->existente) {//Reviso si ya existe, si no, lo creo
            foreach ($this->atributos as $campo => $campoValor) {//Genero string de campos y valores
                $subqueryCamps .= $campo . ",";
                $subqueryVals .= "'" . $campoValor . "',";
            }
            $subqueryCamps = rtrim($subqueryCamps, ","); //Elimina la última coma
            $subqueryVals = rtrim($subqueryVals, ","); //Elimina la última coma

            $query = "INSERT INTO $this->tabla ($subqueryCamps) VALUES ($subqueryVals)";
            $resultado = $this->dbExecute($query);
            if ($resultado != false) {
                $this->existente = true;
                return true;
            } else {
                Debug::getInstance()->alert("EntidadBD::almacenarEnBD => No se pudo insertar.");
                return false;
            }
        }
    }

    public function eliminarDeBD() {
        foreach ($this->atributos as $campo => $campoValor) {
            $condiciones .= $campo . "=" . $campoValor . " AND ";
        }
        $condiciones = preg_replace('/\W\w+\s*(\W*)$/', '$1', $condiciones);
        $query = "DELETE FROM $this->tabla WHERE " . $condiciones;
        Debug::getInstance()->alert("DELETE - $query");
        $resultado = $this->dbExecute($query);
        if ($resultado === true) {
            return true;
        } else {
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
    }

    public function service_selectIndividual($callback) {
        foreach ($this->atributos as $campo => $campoValor) {
            $condiciones .= $campo . "=" . $campoValor . " AND ";
        }

        $condiciones = preg_replace('/\W\w+\s*(\W*)$/', '$1', $condiciones);


        $query = "SELECT * FROM $this->tabla WHERE $condiciones LIMIT 1";
        $resultado = $this->dbExecute($query);
        if ($resultado != false) {
            $finalData = array("Resultados" => $resultado->fetch_assoc());
            if ($callback != "") {
                $json = "$callback(" . json_encode($finalData) . ")";
            } else {
                $json = json_encode($finalData);
            }
            print_r($json);
        }
        return $resultado;
    }

    public function service_insert($callback) {
        foreach ($this->atributos as $campo => $campoValor) {
            $subqueryCamps .= $campo . ",";
            $subqueryVals .= "'" . $campoValor . "',";
        }
        $subqueryCamps = rtrim($subqueryCamps, ","); //Elimina la última coma
        $subqueryVals = rtrim($subqueryVals, ","); //Elimina la última coma

        $query = "INSERT INTO $this->tabla ($subqueryCamps) VALUES ($subqueryVals)";
        Debug::getInstance()->alert("Insert - $query");
        $resultado = $this->dbExecute($query);
        if ($resultado != false) {
            $finalData = array("Resultados" => $this->atributos);
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

    public function service_update($callback) {
        print '[null]';
    }

    public function service_delete($callback) {
        $json = array();
        foreach ($this->atributos as $campo => $campoValor) {
            $condiciones .= $campo . "=" . $campoValor . " AND ";
        }

        $condiciones = preg_replace('/\W\w+\s*(\W*)$/', '$1', $condiciones);

        $query = "DELETE FROM $this->tabla WHERE " . $condiciones;
        $resultado = $this->dbExecute($query);
        if ($resultado === true) {
            array_push($json, $this->atributos);
        }
        $finalData = array("Resultados" => $json);
        if ($callback != "") {
            $json = "$callback(" . json_encode($finalData) . ")";
        } else {
            $json = json_encode($finalData);
        }
        print_r($json);
        return $resultado;
    }

}