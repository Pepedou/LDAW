<?php

/**
 * Clase para realizar conexión con la Base de Datos
 *
 * @author estef
 */
class DatabaseManager {

    private
            $host = "localhost",
            $username = "1018566_user",
            $password = "1018566",
            $nombreBD = "ldaw@1018566",
            $db;

    function connectToDatabase() { // create a function for connect database
        $this->db = new mysqli($this->host, $this->username, $this->password, $this->nombreBD);

        if ($this->db->connect_errno) {//Probamos la conexión
            echo "No se pudo conectar a la BD [" . $this->db->connect_error . "]<br>";
            return false;
        } else {            
            echo "Conexión establecida!";
            return true;
        }
    }

    function executeQuery($query) {
        if (!$resultado = $this->db->query($query)) {
            echo "Error al ejecutar el query [" . $this->db->error . "]<br>";
            return false;
        } else {
            echo "Query Ejecutado! " . $this->db->affected_rows . " <br>";
            return $resultado;
        }
    }

    function closeConnection() { // close the connection
        $this->db->close();
        echo "Conexión terminada<br>";
    }
}
?>





