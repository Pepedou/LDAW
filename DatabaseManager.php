<?php

/**
 * Clase para realizar conexión con la Base de Datos
 *
 * @author estef
 */
class DatabaseManager {

<<<<<<< HEAD
    var $host = "localhost";
    var $username = "1018566_user";    // specify the sever details for mysql
    var $password = "1018566";
    var $database = "ldaw@1018566";
    var $myconn;

    function connectToDatabase() { // create a function for connect database

        $conn = mysql_connect($this->host, $this->username, $this->password);

        if (!$conn) {// testing the connection
            die("Cannot connect to the database");
        } else {

            $this->myconn = $conn;
            echo "Connection established";
        }

        return $this->myconn;
    }

    function selectDatabase() { // selecting the database.
        mysql_select_db($this->database);  //use php inbuild functions for select database

        if (mysql_error()) { // if error occured display the error message
            echo "Cannot find the database " . $this->database;
        }
        echo "Database selected..";
    }

    function executeQuery($query) {
        echo $query;
        mysqli_query($this->myconn, $query);        
        if (mysql_error()) { // if error occured display the error message
            echo "Error al ejecutar el query " . $this->database;
        } else {
            echo "Executed Query";
=======
    private
            $host = "localhost",
            $username = "1018566_user",
            $password = "1018566",
            $nombreBD = "ldaw@1018566",
            $db;

    function connectToDatabase() { // create a function for connect database
        $this->db = new mysqli($this->host, $this->username, $this->password, $this->nombreBD);

        if (!$this->db->connect_errno > 0) {//Probamos la conexión
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
>>>>>>> a8fe4eac9dcb3e2d6c3471c3b9c2bdd3bbbff289
        }
    }

    function closeConnection() { // close the connection
<<<<<<< HEAD
        mysql_close($this->myconn);

        echo "Connection closed";
    }

=======
        $this->db->close();
        echo "Conexión terminada<br>";
    }
>>>>>>> a8fe4eac9dcb3e2d6c3471c3b9c2bdd3bbbff289
}
?>




<<<<<<< HEAD
=======

>>>>>>> a8fe4eac9dcb3e2d6c3471c3b9c2bdd3bbbff289
