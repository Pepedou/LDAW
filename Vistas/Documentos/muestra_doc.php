<?php
include_once '../../Clases/Documento.php';

$id = $_REQUEST['id'];
$doc = new Documento();

$dbManager = DatabaseManager::getInstance();
$dbManager->connectToDatabase();
$query = "SELECT documento,nombre,id_Tipo,tamano FROM " . static::$tabla_static . " WHERE id =" . $seleccion . " AND visible = 1";
$resultado = $dbManager->executeQuery($query);
$dbManager->closeConnection();

if ($resultado != false) {
    if ($resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
        if ($row['id_Tipo'] === 1) { //si es pdf
            $tipo = "application/pdf";
        } else {
            $tipo = "application/pdf";  //solo de prueba, cambiar esto
        }
        $content = $row['documento'];
        $nombre = $row['nombre'];
        $tamano = $row['tamano'];
    } else {
        Debug::getInstance()->alert("El archivo no se encuentra disponible.");
    }
}

header("Content-type: $tipo");
header("Content-length: $tamano");
while (@ob_end_clean());
//header("Content-Disposition: attachment; filename=\"$nombre\"");
echo $content;


