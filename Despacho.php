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

    public $id = -1, $nombre, $direccion;
    private $dbManager,
            $tabla = "Despachos",
            $campos = "Nombre,Direccion";

    public function __construct() {
        echo "Nuevo despacho!<br>";
        $this->dbManager = DatabaseManager::getInstance();
        $this->nombre = "Despacho" . $this->id;
        $this->direccion = "ND";
    }

    public function cargarDespachoDeBD($despacho) {
        $dbManager = DatabaseManager::getInstance();
        $dbManager->connectToDatabase() or die("No se pudo conectar a la BD.");
        $resul = false;
        $query = "SELECT Nombre,Direccion FROM Despachos WHERE Nombre='$despacho'";

        $resultado = $dbManager->executeQuery($query);
        if ($resultado->num_rows) {
            $fila = $resultado->fetch_assoc();
            $this->id = $fila['id'];
            $this->nombre = $fila['Nombre'];
            $this->direccion = $fila['Direccion'];
            $resul = true;
        }
        $dbManager->closeConnection();
        return $resul;
    }

    public function eliminarDeBD() {
        if ($this->id > -1) {
            $query = "DELETE FROM " . $this->tabla . " WHERE ID = " . $this->id;
            $dbManager = $this->dbManager;
            $dbManager->connectToDatabase() or die("No se pudo conectar a la BD");
            $dbManager->executeQuery($query);
            $dbManager->closeConnection();
            return true;
        } else {
            return false;
        }
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
        $dbManager = $this->dbManager;
        $query = "INSERT INTO " . $this->tabla . " (" . $this->campos . ") VALUES ('" . $this->nombre . "','" . $this->direccion . "')";
        $res = false;
        if ($this->validarDatos()) {
            $dbManager->connectToDatabase();
            $resultado = $dbManager->executeQuery($query);
            if ($resultado) {
                echo "Despacho guardado en BD!<br>";
                $res = true;
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
    
       public function get_Id($nombre){
        
        $dbManager = DatabaseManager::getInstance();
        $dbManager->connectToDatabase();
        $query = "Select id FROM Despachos WHERE Nombre = '$nombre' LIMIT 1";
        $resultado = $dbManager->executeQuery($query);
        $row = mysql_fetch_assoc($resultado);
        $dbManager->closeConnection();
        echo $row;
        $this->id = $row;
        
        
    }

}
