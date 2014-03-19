<?php

header('content-type: application/json; charset=utf-8');
include './DatabaseManager.php';

$dbManager = DatabaseManager::getInstance();
$dbManager->connectToDatabase();

$param = array();

$op = $_REQUEST['op'];

switch ($op) {
    
    
    case "s":

        $Abogados_json = array(); //arreglo de arreglos de Despachos
        $query = "SELECT * FROM Abogados ";
        
        $result = $dbManager->executeQuery($query);

        if ($result->num_rows) {

             while ($fila = $result->fetch_assoc()) {
                 
                    $Abogados = array(); //crea un nuevo arreglo por resultado
                    $Abogados['id'] = $fila['id'];
                    $Abogados['Nombre'] = $fila['nombre'];
                    $Abogados['ApellidoP'] = $fila['apellidoP'];
                    $Abogados['ApellidoM'] = $fila['apellidoM'];
                    $Abogados['Telefono'] = $fila['telefono'];
                    $Abogados['Email'] = $fila['email'];
                    
                                  
                    /* Traer también la información del Rol designado */
                    $query_rol = "SELECT rol FROM Roles WHERE id =" . $fila['id_Rol'];
                    $result_rol = $dbManager->executeQuery($query_rol);
                    
                    if ($result_rol->num_rows) {

                        $rol = $result_rol->fetch_assoc();
                        $Abogados['Rol'] = $rol['rol'];
                    }
                    
                    /* Conseguir el nombre del Despacho al que pertenece */
                    $query_desp = "SELECT nombre FROM Despachos WHERE id =" . $fila['id_Despacho'];
                    $result_desp = $dbManager->executeQuery($query_desp);
                    
                    if ($result_desp->num_rows) {

                        $desp = $result_desp->fetch_assoc();
                        $Abogados['Despacho'] = $desp['nombre'];
                    }
                 array_push($Abogados_json, $Abogados); 
             }

        }
        $dbManager->closeConnection();
        echo 'Abogados:' . json_encode($Abogados_json);

        break;
      
    
    
    
    
}//fin switch