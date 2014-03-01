<?php

header('content-type: application/json; charset=utf-8');
include './DatabaseManager.php';

$dbManager = DatabaseManager::getInstance();
$dbManager->connectToDatabase();


$param = array();

$op = $_REQUEST['op'];


switch ($op) {

    case "s":

        $Despachos_json = array(); //arreglo de arreglos de Despachos
        $query = "SELECT * FROM Despachos";

        $result = $dbManager->executeQuery($query);

        if ($result->num_rows) {


            while ($fila = $result->fetch_assoc()) {

                if ($fila['visible'] === "1") { //verifica que el despacho se pueda ver
                    $Despachos = array(); //crea un nuevo arreglo por resultado
                    $Despachos['id'] = $fila['id'];
                    $Despachos['Nombre'] = $fila['nombre'];

                    /* Traer también la información de la dirección relacionada */
                    $query_dir = "SELECT * FROM Direcciones WHERE id =" . $fila['id_Direccion'];
                    $result_dir = $dbManager->executeQuery($query_dir);

                    if ($result_dir->num_rows) {

                        $dir = $result_dir->fetch_assoc();

                        $Despachos['Calle'] = $dir['calle'];
                        $Despachos['Colonia'] = $dir['colonia'];
                        $Despachos['Delegacion'] = $dir['delegacion'];
                    }
                    array_push($Despachos_json, $Despachos); //mete el despacho a la lista de despachos
                }
            }
        }

        $dbManager->closeConnection();

        echo 'JSON:' . json_encode($Despachos_json);
        break;

    case "i" :

        $param = $_GET['param']; //Cambiar a Post

        if (count($param) === 7) { //nombre, calle , colonia, delegación, ciudad ,cp
            $nombre = $param['nombre'];
            $calle = $param['calle'];
            $colonia = $param['colonia'];
            $id_M = $param['id_M'];
            $cd = $param['cd'];
            $id_Edo = $param['id_Edo'];
            $cp = $param['cp'];

            $query_dir = "INSERT INTO Direcciones (calle, colonia, id_Municipio , ciudad, id_Estado,cp) VALUES ('$calle', '$colonia', '$id_M', '$cd', '$id_Edo',$cp)";
            $dbManager->executeQuery($query_dir);

            $query_id = "SELECT id FROM Direcciones WHERE calle = '$calle' AND colonia = '$colonia' LIMIT 1";
            $result_dir = $dbManager->executeQuery($query_id);
            $dir = $result_dir->fetch_assoc();
            $id_dir = $dir['id'];

            $query = "INSERT INTO Despachos (nombre, id_Direccion) values ('$nombre' , '$id_dir')";
            $result = $dbManager->executeQuery($query);
            $dbManager->closeConnection();
        } else {

            echo 'Faltan  Parámetros para la Inserción';
            $dbManager->closeConnection();
        }

        break;

    case "u" :
        $param = $_GET['param']; //Cambiar a Post

        $id = $param['id'];
        $nombre = $param['nombre'];
        $calle = $param['calle'];
        $colonia = $param['colonia'];
        $id_M = $param['id_M'];
        $cd = $param['cd'];
        $id_Edo = $param['id_Edo'];
        $cp = $param['cp'];       

        $query_dir = "SELECT id_Direccion FROM Despachos WHERE id = '$id'";
        $result_dir = $dbManager->executeQuery($query_dir);
        $dir = $result_dir->fetch_assoc();
        $id_dir = $dir['id_Direccion'];
        
        if (strlen($nombre) > 0) {
            $query_up = "UPDATE Despachos SET nombre='$nombre' WHERE id='$id'";
            $dbManager->executeQuery($query_up);
        }
        $query_up = "UPDATE Direcciones SET calle = '$calle', colonia = '$colonia', ciudad = '$ciudad', id_Municipio = $id_M, id_Estado = $id_Edo, cp = $cp WHERE id = $id_dir";
        $dbManager->executeQuery($query_up);

        break;

    case "d" :

        $nombre = $_GET['nombre']; //Cambiar a Post     
        $query = "UPDATE Despachos SET visible = 0 WHERE nombre= '$nombre'";

        $result = $dbManager->executeQuery($query);

        /* if ($result->affected_rows) {
          echo 'Despacho Elimindao!';
          }  else {

          echo 'El despacho no se ha podido borrar';
          } */

        break;
} //fin switch
?>
