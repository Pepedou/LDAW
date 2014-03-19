<?php

/**
 * Clase para realizar conexión con la Base de Datos
 *
 * @author estef
 */

include './Debug.php';

class DatabaseManager {

    static private $instancia = NULL;

    public static function getInstance() {
        if (self::$instancia == NULL) {
            self::$instancia = new DatabaseManager();
        }
        return self::$instancia;
    }

    public function connectToDatabase() { // create a function for connect database
        $this->db = new mysqli($this->host, $this->username, $this->password, $this->nombreBD);

        if ($this->db->connect_errno) {//Probamos la conexión
            echo "No se pudo conectar a la BD [" . $this->db->connect_error . "]<br>";
            return false;
        } else {
            echo "Conexión establecida!";
            return true;
        }
    }

    public function executeQuery($query) {
        if (!$resultado = $this->db->query($query)) {
            echo "Error al ejecutar el query [" . $this->db->error . "]<br>";
            return false;
        } else {
            echo "Query Ejecutado! " . $this->db->affected_rows . " <br>";
            return $resultado;
        }
    }

    public function closeConnection() { // close the connection
        $this->db->close();
        echo "Conexión terminada<br>";
    }

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

}
?>





