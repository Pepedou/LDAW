<?php
include_once '../config.ink.php';
include_once 'DatabaseManager.php';

/**
 * Description of ServicioGenerico
 *
 * @author José Luis Valencia Herrera   A01015544
 */
class ServicioGenerico {

    protected $tabla, $discr, $discrValor;
    public $atributos = array();

    public function service_selectTodos($callback) {
        $json = array();
        $query = "SELECT * FROM $this->tabla";
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
        $query = "SELECT * FROM $this->tabla WHERE $this->discr = '$this->discrValor'";
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
        $query = "SELECT * FROM $this->tabla WHERE id = ".$this->atributos['id'];
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
        $json = array();
        foreach ($this->atributos as $campo => $campoValor) {
            if ($campo != "id") {
                $subquerySets .= $campo . "='" . $campoValor . "',";
            }
        }
        $subquerySets = rtrim($subquerySets, ","); //Elimina la última coma

        $query = "UPDATE $this->tabla SET $subquerySets WHERE $this->discr = '$this->discrValor'";
        Debug::getInstance()->alert("Update - $query");
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
        $query = "UPDATE $this->tabla SET visible = 0 WHERE $this->discr = '$this->discrValor'";
        Debug::getInstance()->alert("DELETE - $query");
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
