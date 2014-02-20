<?php

include ('Conection.php');


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
     $id, $nombre, $apellidop, $apellidom, $telefono,  $mail, 
     $usuario, $pwd,$id_rol, $id_despacho;
    
    public function _construct($usuario,$pwd){
        
        
    }
    
    public function _destruct($id){
        
    }
    
    
}
