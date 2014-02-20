<?php

include ('./DatabaseManager.php');


/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Clase para añadir, borrar, actualizar o borrar Abogados de la base de datos.
 *
 * @author estef
 */
class Abogado {

    public
            $id, $nombre, $apellidop, $apellidom, $telefono, $mail,
            $usuario, $pwd, $id_rol, $id_despacho = -1;

    public function _construct($user, $pass) {

        if (verifica_usuario) {
            $this->usuario = $user;
            $this->pwd = $pass;
        } else {
            echo 'Usuario no valido';
        }
    }

    public function _destruct($id) {
        
    }

    public function verifica_usuario($user) {

        $dbManager = new DatabaseManager();
        $dbManager->connectToDatabase(); //i created a new object
        $dbManager->selectDatabase();

        $sql = "SELECT ";
    }

    public function guardar() {

        $dbManager = new DatabaseManager();
        $dbManager->connectToDatabase(); //i created a new object
        $dbManager->selectDatabase();
    }

}
