<?php

/**
* Description of AbogadosCasos
*
* @author José Luis Valencia Herrera A01015544
*/
include_once './Clases/RelacionMaM.php';
include_once './Clases/Abogado.php';
include_once './Clases/Caso.php';

class AbogadosCasos extends RelacionMaM {

    static private $tabla_static = "Abogados_Casos";

    public function __construct() {
        parent::__construct();
        $this->tabla = static::$tabla_static;
        $this->atributos = array(
            "id_Abogado" => -1,
            "id_Caso" => -1
        );
    }

    public function cargarCasos() {
        $casos = array();
        $aux = new Caso();
        $query = "SELECT * FROM " . Caso::getNombreTabla() . " JOIN " . static::$tabla_static . " on " . Caso::getNombreTabla() . ".id = " . static::$tabla_static . ".id_Caso WHERE " . static::$tabla_static . ".id_Abogado = " . $this->atributos['id_Abogado'];

        $resultado = $this->dbExecute($query);
        
        if ($resultado->num_rows) {
            $fila = $resultado->fetch_assoc();
            $aux->guardarDatos($fila);
            array_push($casos, $aux);
        }

        return $casos;
    }

    public function cargarAbogados() {
        $abogados = array();
        $aux = new Abogado();
        $query = "SELECT * FROM " . Abogado::getNombreTabla() . " JOIN " . static::$tabla_static . " on " . Abogado::getNombreTabla() . ".id = " . static::$tabla_static . ".id_Abogado WHERE " . static::$tabla_static . ".id_Caso = " . $this->atributos['id_Caso'];


        $resultado = $this->dbExecute($query);

        if ($resultado->num_rows) {
            $fila = $resultado->fetch_assoc();
            $aux->guardarDatos($fila);
            array_push($abogados, $aux);
        }

        return $abogados;
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

    public static function getNombreTabla() {
        return static::$tabla_static;
    }

    public function service_selectTodosID($misDatos, $callback) {
        $resultados = array();
        $atributos = array();
        switch ($misDatos['campo']) {
            case 'Abogado':
            case 'Abogados':
                $resultados = $this->cargarAbogados();
                break;
            case 'Caso':
            case 'Casos':
                $resultados = $this->cargarCasos();
                break;
        }

        foreach ($resultados as $objeto){
            array_push($atributos, $objeto->atributos);
        }
        $finalData = array("Resultados" => $atributos);
        if ($callback != "") {
            $json = "$callback(" . json_encode($finalData) . ")";
        } else {
            $json = json_encode($finalData);
        }
        print_r($json);
    }

}