<?php

/**
 * Clase para realizar conexión con la Base de Datos
 *
 * @author estef
 */
include 'Debug.php';

class DatabaseManager {

    static private $instancia = NULL;

    private function __construct() {
        $this->host = "localhost";
        $this->username = "1018566_user";
        $this->password = "1018566";
        $this->nombreBD = "ldaw@1018566";
        $this->db;
    }

    private
            $host,
            $username,
            $password,
            $nombreBD,
            $db;

    public static function getInstance() {
        if (self::$instancia == NULL) {
            self::$instancia = new DatabaseManager();
        }
        return self::$instancia;
    }

    public function connectToDatabase() { // create a function for connect database
        $this->db = new mysqli($this->host, $this->username, $this->password, $this->nombreBD);

        if ($this->db->connect_errno) {//Probamos la conexión
            Debug::getInstance()->alert("No se pudo conectar a la BD [" . $this->db->connect_error . "]");
            return false;
        } else {
            return true;
        }
    }

    public function executeQuery($query) {
       
        if (!$resultado = $this->db->query($query)) {
          
            Debug::getInstance()->alert("DBManager => Error [" . $this->db->error . "] al ejecutar el query -> " . $query);
        }
        return $resultado;
    }

    public function closeConnection() { // close the connection
        
        $this->db->close();
       
    }

}
?>





