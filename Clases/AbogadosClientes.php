<?php

/**
 * Description of AbogadosClientes
 *
 * @author José Luis Valencia Herrera     A01015544
 */
include_once 'RelacionMaM.php';
include_once 'Abogado.php';
include_once 'Cliente.php';

class AbogadosClientes extends RelacionMaM {

    static private $tabla_static = "Abogados_Clientes";

    public function __construct() {
        parent::__construct();
        $this->tabla = static::$tabla_static;
        $this->atributos = array(
            "id_Abogado" => -1,
            "id_Cliente" => -1
        );
    }

    public function cargarClientes() {
        $clientes = array();
        $aux = new Cliente();
        $query = "SELECT * FROM " . Cliente::getNombreTabla() . " JOIN " . static::$tabla_static . " on " . Cliente::getNombreTabla() . ".id = " . static::$tabla_static . ".id_Cliente WHERE " . static::$tabla_static . ".id_Abogado = " . $this->atributos['id_Abogado'];

        $resultado = $this->dbExecute($query);

        if ($resultado->num_rows) {
            $fila = $resultado->fetch_assoc();
            $aux->guardarDatos($fila);
            array_push($clientes, $aux);
        }

        return $clientes;
    }

    public function cargarAbogados() {
        $abogados = array();
        $aux = new Abogado();
        $query = "SELECT * FROM " . Abogado::getNombreTabla() . " JOIN " . static::$tabla_static . " on " . Abogado::getNombreTabla() . ".id = " . static::$tabla_static . ".id_Abogado WHERE " . static::$tabla_static . ".id_Cliente = " . $this->atributos['id_Cliente'];


        $resultado = $this->dbExecute($query);

        if ($resultado->num_rows) {
            while ($fila = $resultado->fetch_assoc()) {
                $aux = new Abogado();
                $aux->guardarDatos($fila);
                array_push($abogados, $aux);
            }
        }
        return $abogados;
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
            case 'Cliente':
            case 'Clientes':
                $resultados = $this->cargarClientes();
                break;
        }
        foreach ($resultados as $objeto) {
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
    
    public function generarFormaActualizacion() {
        
    }

    public function generarFormaBorrado() {
        
    }

    public function generarFormaInsercion() {
        
    }

    public function procesarForma() {
        
    }

}
