<?php

class Abogado {

    public
            $id, $nombre, $apellidoP, $apellidoM, $telefono, $mail,
            $usuario = "", $pwd, $id_rol, $id_despacho = 1;

    public function _construct() {
        $this->id = -1;
    }

    public function cargarUsuarioDeBD($usuario) {
        $dbManager = new DatabaseManager();
        $dbManager->connectToDatabase() or die("No se pudo conectar a la BD.");

        $query = "SELECT * FROM Abogados WHERE Usuario='$usuario'";

        $resultado = $dbManager->executeQuery($query);
        if ($resultado->num_rows) {
            $fila = $resultado->fetch_assoc();
            $this->id = $fila['id'];
            $this->nombre = $fila['Nombre'];
            $this->apellidoP = $fila['ApellidoP'];
            $this->apellidoM = $fila['ApellidoM'];
            $this->telefono = $fila['Telefono'];
            $this->mail = $fila['Email'];
            $this->usuario = $fila['Usuario'];
            $this->pwd = $fila['Contrasena'];
            $this->id_rol = $fila['id_Rol'];
            $this->id_despacho = $fila['id_Despacho'];
        }
        $dbManager->closeConnection();
    }

    public function devuelveDespacho() {
        $dbManager = new DatabaseManager();
        $dbManager->connectToDatabase();

        $despacho = new Despacho();

        $query = "SELECT * FROM Despachos WHERE id=$this->id_despacho";
        /* $resultado = $dbManager->executeQuery($query); */
    }

    public function verificaUsuario() {
        if (strlen($this->usuario) === 0 || strlen($this->usuario) > 20) {
            echo 'Longitud de usuario no valida';
            return false;
        } else {
            $dbManager = new DatabaseManager();
            $dbManager->connectToDatabase();

            $query = "SELECT Usuario FROM Abogados WHERE Usuario='$user'";

            $resultado = $dbManager->executeQuery($query);
            //$row = $resultado->fetch_array(MYSQLI_NUM);
            /* obtener el array de objetos */

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

        $sql = "INSERT INTO Abogados (Nombre,ApellidoP, ApellidoM, Telefono, Email, Usuario, Contrasena,id_Rol, id_Despacho) values ( '$this->nombre', '$this->apellidop', '$this->apellidom', '$this->telefono',  '$this->mail', 
                '$this->usuario', sha1('$this->pwd'),$this->id_rol, $this->id_despacho)";
        echo $sql;

        $dbManager->executeQuery($sql);

        $dbManager->closeConnection();
    }

}
