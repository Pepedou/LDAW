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
include './DatabaseManager.php';

class Despacho {

    public $id, $nombre, $direccion;

    public function __construct() {
        echo "Nuevo despacho!<br>";
        $this->nombre = "Despacho" . $this->id;
        $this->direccion = "ND";
    }

    public function eliminarDeBD() {
        
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

    public function validarDatos() {
        if ($this->validarNombre() && $this->validarDireccion()) {
            return true;
        } else {
            return false;
        }
    }

    public function almacenarEnBD() {
        $tabla = "Despachos";
        $campos = "Nombre,Direccion";
        $query = "INSERT INTO " . $tabla . " (" . $campos . ") VALUES ('" . $this->nombre . "','" . $this->direccion . "')";
        $res = false;
        if ($this->validarDatos()) {
            $dbManager = new DatabaseManager();
            $dbManager->connectToDatabase();
            $resultado = $dbManager->executeQuery($query);
            if ($resultado === 1) {
                echo "Despacho guardado en BD!<br>";                
                $res =  true;
            } else {
                echo "No se pudo guardar en BD!<br>";
                $res = false;
            }
        } else {
            echo "Los datos están mal!<br>";
            $res = false;
        }        
        $dbManager->closeConnection();
        return $res;
    }

}
