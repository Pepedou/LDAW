<?php

/**
 * Clase para realizar conexión con la Base de Datos
 *
 * @author estef
 */
class DatabaseManager {

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
        }
    }

    function closeConnection() { // close the connection
        mysql_close($this->myconn);

        echo "Connection closed";
    }

}
?>




