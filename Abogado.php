<?php

include ('DatabaseManager.php');


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
            $usuario, $pwd, $id_rol, $id_despacho;

    public function _construct($user, $pass, $id_despacho) {
       
        if ($this->verifica_usuario($user)) {
            $this->usuario = $user;
            $this->pwd = $pass;
            $this->id_despacho = $id_despacho;
            echo 'Usuario Nuevo';
        } 
        else {
            echo 'Usuario no valido';
        }
     
    }

    public function _destruct($id) {
        
    }

    public function verifica_usuario($user) {
        
        if (strlen($user) === 0 || strlen($user)> 20){
            echo 'Longitud de usuario no valida';
        }
        
        else{

        $dbManager = new DatabaseManager();
        $dbManager->connectToDatabase(); //i created a new object
        $dbManager->selectDatabase();

        $sql = "SELECT Usuario FROM Abogados WHERE Usuario = $user";
        $result = $dbManager->executeQuery($sql);
        $num = mysql_num_rows($result);
        echo $num;

        if ($num > 0) {

            return 0; //se puede usar el usuario
        } else {

            return 1; //usuario ocupado
        }

        $dbManager->closeConnection();
        }
    }

    public function almacenarEnBD() {

        $dbManager = new DatabaseManager();
        $dbManager->connectToDatabase(); //i created a new object
        $dbManager->selectDatabase();

        $sql = "INSERT INTO Abogados () values ( $nombre, $apellidop, $apellidom, $telefono,  $mail, 
                $usuario, sha1($pwd),$id_rol, $id_despacho)";

        $result = $dbManager->executeQuery($sql);

        $dbManager->closeConnection();
    }

}
