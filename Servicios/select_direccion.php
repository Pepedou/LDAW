<?php

include_once '../Clases/EntidadBD.php';
include_once '../Clases/DatabaseManager.php';

$op = $_REQUEST['op'];
$edo = $_REQUEST['edo'];

switch ($op) {

    case 1:
        // alert("sad");
        $dbM = DatabaseManager::getInstance();
        $dbM->connectToDatabase();
        $query = "SELECT id, Estado  FROM Estados WHERE Paises_id=1"; //siempre es México
        $resultado = $dbM->executeQuery($query);
        echo "<select name=\"estado\">
          <option>Seleccione el estado</option>";

        while ($row = $resultado->fetch_assoc()) {

            echo"<option value =" . $row['id'] . " >" . $row['Estado'] . "</option>";
        }

        echo "</select>";

        $dbM->closeConnection();
        break;


    case 2:
        $dbM = DatabaseManager::getInstance();
        $dbM->connectToDatabase();
        $query = "SELECT id, Municipio  FROM Municipios WHERE Estados_id='$edo'";
        $resultado = $dbM->executeQuery($query);
        echo "<select name=\"ciudad\">
          <option>Seleccione la ciudad</option>";

        while ($row = $resultado->fetch_assoc()) {

            echo"<option value =" . $row['id'] . " >" . $row['Municipio'] . "</option>";
        }
        echo "</select>";
        $dbM->closeConnection();
        break;
    case 3: //despachos
        $dbM = DatabaseManager::getInstance();
        $dbM->connectToDatabase();
        $query = "SELECT id, nombre  FROM Despachos WHERE visible = 1";
        $resultado = $dbM->executeQuery($query);
        echo "<select name=\"despacho\">
          <option>Seleccione Despacho</option>";

        while ($row = $resultado->fetch_assoc()) {

            echo"<option value =" . $row['id'] . " >" . $row['nombre'] . "</option>";
        }
        echo "</select>";
        $dbM->closeConnection();

        break;
    case 4:
        $dbM = DatabaseManager::getInstance();
        $dbM->connectToDatabase();
        $query = "SELECT id, rol  FROM Roles";
        $resultado = $dbM->executeQuery($query);
        echo "<select name=\"rol\">
          <option>Seleccione Rol</option>";

        while ($row = $resultado->fetch_assoc()) {

            echo"<option value =" . $row['id'] . " >" . $row['rol'] . "</option>";
        }
        echo "</select>";
        $dbM->closeConnection();
        break;
    default:
        echo"Necesito la opcion";
        break;
}
