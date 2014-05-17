<?php

include_once 'DatabaseManager.php';

/**
 * Description of ServicioGenerico
 *
 * @author José Luis Valencia Herrera   A01015544
 */
class ServicioGenerico {

    protected $tabla, $discr, $discrValor;
    public $atributos = array();

    public function getDiscriminante() {
        return $this->discr;
    }

    public function service_selectTodos($callback) {
        $json = array();
        if (array_key_exists('visible', $this->atributos)) {//Verifico si la tabla tiene el campo visible
            $query = "SELECT * FROM $this->tabla WHERE visible = 1";
        } else {
            $query = "SELECT * FROM $this->tabla";
        }
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

    public function service_selectTodosWhere($misDatos, $callback) {
        $json = array();
        foreach ($misDatos as $campo => $valor) {
            $condicion .= "$campo = '$valor' AND ";
        }
        $condicion = preg_replace('/\W\w+\s*(\W*)$/', '$1', $condicion); //Elimina el último AND

        $dbManager = DatabaseManager::getInstance();
        $dbManager->connectToDatabase();

        if (array_key_exists('visible', $this->atributos)) {
            $query = "SELECT * FROM " . $this->tabla . " WHERE $condicion AND visible = 1";
        } else {
            $query = "SELECT * FROM " . $this->tabla . " WHERE $condicion";
        }
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

    public function service_selectIndividual($callback) {
        $json = array();
        if (array_key_exists('visible', $this->atributos)) {//Verifico si la tabla tiene el campo visible
            $query = "SELECT * FROM $this->tabla WHERE $this->discr = '$this->discrValor' AND visible = 1";
        } else {
            $query = "SELECT * FROM $this->tabla WHERE $this->discr = '$this->discrValor'";
        }
        $resultado = $this->dbExecute($query);
        if ($resultado != false) {
            array_push($json, ($resultado->fetch_assoc()));
            $finalData = array("Resultados" => $json);
            if ($callback != "") {
                $json = "$callback(" . json_encode($finalData) . ")";
            } else {
                $json = json_encode($finalData);
            }
            print_r($json);
        }
        return $resultado;
    }

    public function service_selectIndividualID($callback) {
        $json = array();
        if (array_key_exists('visible', $this->atributos)) {//Verifico si la tabla tiene el campo visible
            $query = "SELECT * FROM $this->tabla WHERE id = " . $this->atributos['id'] . " AND visible = 1";
        } else {
            $query = "SELECT * FROM $this->tabla WHERE id = " . $this->atributos['id'];
        }
        $resultado = $this->dbExecute($query);
        if ($resultado != false) {
            array_push($json, ($resultado->fetch_assoc()));
            $finalData = array("Resultados" => $json);
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
        $json = array();
        foreach ($this->atributos as $campo => $campoValor) {
            if ($campo != "id") {
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

    public function service_delete($callback) {
        $json = array();
        $id = $this->atributos['id'];
        if (array_key_exists('visible', $this->atributos)) {//Verifico si la tabla tiene el campo visible
            $query = "UPDATE $this->tabla SET visible = 0 WHERE  id = $id";
        } else {
            $query = "DELETE FROM $this->tabla WHERE id = $id";
        }       
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

    protected function dbExecute($query) {
        $dbM = DatabaseManager::getInstance();
        $dbM->connectToDatabase();
        $resultado = $dbM->executeQuery($query);
        $dbM->closeConnection();
        return $resultado;
    }

}
