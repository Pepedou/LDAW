<?php

include_once '../Clases/EntidadBD.php';
include_once '../Clases/DatabaseManager.php';

$op = $_REQUEST['op'];

switch($op){

case 1:
   // alert("sad");
    $dbM = DatabaseManager::getInstance();
    $dbM->connectToDatabase();
    $query = "SELECT id, Estado  FROM Estados WHERE Paises_id=1"; //siempre es México
    $resultado = $dbM->executeQuery($query);
    echo "<select name=\"estado\">
          <option>Seleccione el estado</option>";

    while ($row = $resultado->fetch_assoc()){

    echo"<option value =".$row['id']." >" .$row['Estado']."</option>";
    }


    echo "</select>";
    
    $dbM->closeConnection();
    break;
    
default:
    echo"Necesito la opcion";
    break;

}
