<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Clase para la creación, actualización y borrado de Casos
 *
 * @author estef
 */
class Caso {

    public
            $id, $nombre, $status, $id_despacho;

    public function __construct() {
        
    }

    public function _destruct() {
        
    }

    public function validarNombre() {

        if (strlen($this->nombre) === 0 || strlen($this->nombre) > 100) {
            echo 'Nombre muy largo';
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function almacenarEnBD() {


        if ($this->validarNombre()) {

            $dbManager = new DatabaseManager();
            $dbManager->connectToDatabase();
            
            $sql = "INSERT INTO Casos (Nombre,id_Despacho)values('$this->nombre',$this->id_despacho)";
            echo $sql;
            $dbManager->executeQuery($sql);

            $dbManager->closeConnection();
        }
    }

}
