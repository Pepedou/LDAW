<?php

include './DatabaseManager.php';

class Abogado {

    public
            $id, $nombre, $apellidoP, $apellidoM, $telefono, $mail,
            $pwd, $id_rol, $id_despacho = 1;

    public function _construct() {
        $this->id = -1;
    }

    public function cargarUsuarioDeBD($mail) {
        $dbManager = new DatabaseManager();
        $dbManager->connectToDatabase() or die("No se pudo conectar a la BD.");
        $resul = false;
        $query = "SELECT * FROM Abogados WHERE email='$mail'";

        $resultado = $dbManager->executeQuery($query);
        if ($resultado->num_rows) {
            $fila = $resultado->fetch_assoc();
            $this->id = $fila['id'];
            $this->nombre = $fila['nombre'];
            $this->apellidoP = $fila['apellidoP'];
            $this->apellidoM = $fila['apellidoM'];
            $this->telefono = $fila['telefono'];
            $this->mail = $fila['email'];
            $this->pwd = $fila['contrasena'];
            $this->id_rol = $fila['id_Rol'];
            $this->id_despacho = $fila['id_Despacho'];
            $resul = true;
        }
        $dbManager->closeConnection();
        return $resul;
    }

    public function cargarDespacho() {
        $dbManager = new DatabaseManager();
        $dbManager->connectToDatabase();

        $despacho = new Despacho();

        $query = "SELECT * FROM Despachos WHERE id=$this->id_despacho";
        /* $resultado = $dbManager->executeQuery($query); */
    }

    public function verificaUsuario() {
        if (strlen($this->mail) === 0 || strlen($this->mail) > 30) {
            echo 'Longitud de usuario no valida';
            return false;
        } else {
            $dbManager = new DatabaseManager();
            $dbManager->connectToDatabase();

            $query = "SELECT email FROM Abogados WHERE email='$this->mail'";

            $resultado = $dbManager->executeQuery($query);
            
            if (($resultado->num_rows)) {
                $dbManager->closeConnection();
                return false;
            } else {
                $dbManager->closeConnection();
                return true; //sí esta libre para usarse
            }
        }
    }

    public function almacenarEnBD() {
        $dbManager = new DatabaseManager();
        $dbManager->connectToDatabase();

        $sql = "INSERT INTO Abogados (nombre,apellidoP, apellidoM, telefono, email, contrasena,id_Rol, id_Despacho) values ( '$this->nombre', '$this->apellidoP', '$this->apellidoM', '$this->telefono',  '$this->mail', 
                sha1('$this->pwd'),$this->id_rol, $this->id_despacho)";
        //echo $sql;

        $dbManager->executeQuery($sql);

        $dbManager->closeConnection();
    }
    
    public function get_Id($mail){
        
        $dbManager = new DatabaseManager();
        $dbManager->connectToDatabase();
        
        $query = "Select id FROM Abogados WHERE email = '$mail' LIMIT 1";
        $resultado = $dbManager->executeQuery($query);
        $row = $resultado->fetch_assoc();
        $dbManager->closeConnection();
        echo $row;
        $this->id = $row;
        
        
    }
    
    

}
