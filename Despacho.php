<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Despacho
 *
 * @author José Luis Valencia Herrera     A01015544
 */
class Despacho {

    public $id, $nombre, $direccion;

    public function __construct() {
        echo "Nuevo despacho!<br>";        
        $this->nombre = "Despacho" + $this->id;
        $this->direccion = "ND";
    }
    
    public function eliminarEnBD() {
        
    }

    public function validarNombre() {
        if (strlen($this->nombre) === 0 || strlen($this->nombre) > 50) {
            return false;
        } else {
            return true;
        }
    }

    public function validarDireccion() {
        if (strlen($this->direccion) === 0 || strlen($this->direccion) > 70) {
            return false;
        } else {
            return true;
        }
    }
    
    public function almacenarEnBD() {
        if ($this->validarDireccion() && $this->validarNombre()){
            echo "Guardo en BD!<br>";
            return true;
        }
        else{
            return false;
        }
    }
    
}
