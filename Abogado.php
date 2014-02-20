<?php


include ('DatabaseManager.php');

class Abogado {

    public
            $id, $nombre, $apellidop, $apellidom, $telefono, $mail,

            $usuario, $pwd, $id_rol, $id_despacho=1;

    public function _construct($user, $pass) {
       
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
        $dbManager->connectToDatabase();   
        
        $query = "SELECT Usuario FROM Abogados WHERE Usuario='$user'";
        
        $resultado = $dbManager->executeQuery($query);       

        if ( ($resultado->affected_rows) > 0) {
             
            return 0; 
            
        } else {

            return 1; 
        }

        $dbManager->closeConnection();
        }
    }


    public function almacenarEnBD() {


        $dbManager = new DatabaseManager();
        $dbManager->connectToDatabase();  


        $sql = "INSERT INTO Abogados (Nombre,ApellidoP, ApellidoM, Telefono, Email, Usuario, Contrasena,id_Rol, id_Despacho) values ( '$this->nombre', '$this->apellidop', '$this->apellidom', '$this->telefono',  '$this->mail', 
                '$this->usuario', sha1('$this->pwd'),$this->id_rol, $this->id_despacho)";
        echo $sql;

        $dbManager->executeQuery($sql);

        $dbManager->closeConnection();

    }

}
