<?php

require '../Clases/DatabaseManager.php';


$tabla = "Abogados";
$tabla2 = "Clientes";
$campos = "id";
$db = DatabaseManager::getInstance();

// Obtenemos usuario y password y filtramos para eliminar posibles inyecciones a MySQL
$myusername = mysql_escape_string($_POST['usuario']);
$mypassword = mysql_escape_string($_POST['pwd']);

$sql = "SELECT * FROM $tabla WHERE email ='$myusername' AND contrasena=sha1('$mypassword')";

$db->connectToDatabase() or die("No se pudo obtener acceso a la base de datos.");

$result = $db->executeQuery($sql);

// Si el resultado hace match $myusername y $mypassword, nos debe de regresar 1
if ($result->num_rows === 1) {
    $fila = $result->fetch_assoc();
    $usuario = $fila['email'];
    // Registramos $myusername, $mypassword y redireccionamos a "login_exitoso.php"
    session_register("myusername");
    session_register("mypassword");
    setcookie("usuario", $usuario, time() + (3600 * 24)); //Cookie por 1 día
    $rol = ($fila['id_Rol']);
    if ($rol == 1) { //Si es administrador
        header("location:vista-admin.php"); 
    } else {
        header("location:vista-abogado.php");
    }
} else {
    /* Si no está dentro de Abogados, checamos que no esté en Clientes */
    $sql = "SELECT * FROM $tabla2 WHERE email ='$myusername' AND contrasena=sha1('$mypassword')";
    $result = $db->executeQuery($sql);
    if ($result->num_rows === 1) {
        $fila = $result->fetch_assoc();
        $usuario = $fila['email'];
        // Registramos $myusername, $mypassword y redireccionamos a "main_cliente.php"
        session_register("myusername");
        session_register("mypassword");
        setcookie("usuario", $usuario, time() + (3600 * 24)); //Cookie por 1 día
        header("location:Clientes_CMS/vista_cliente.php");
    } else {
        echo "Usuario o password incorrecto";
        header("Refresh: 3; url=../index.html");
    }
}
$db->closeConnection();
