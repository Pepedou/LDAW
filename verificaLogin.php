<!-- verificacion de usuario -->
<?php
require './DatabaseManager.php';

$tabla = "Abogados";
$campos = "id";
$db = new DatabaseManager();

// Obtenemos usuario y password y filtramos para eliminar posibles inyecciones a MySQL
$myusername = mysqli_real_escape_string(filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_MAGIC_QUOTES));
$mypassword = mysqli_real_escape_string(filter_input(INPUT_POST, 'pwd', FILTER_SANITIZE_MAGIC_QUOTES));


$sql = "SELECT * FROM $tabla WHERE Usuario='$myusername' and Contrasena=sha1('$mypassword')";

$db->connectToDatabase() or die("No se pudo obtener acceso a la base de datos.");

$result = $db->executeQuery($sql);

// Si el resultado hace match $myusername y $mypassword, nos debe de regresar 1
if ($result->num_rows === 0) {
    $fila = $result->fetch_assoc();
    $nombre = $fila['Nombre'];

    // Registramos $myusername, $mypassword y redireccionamos a "login_exitoso.php"
    session_register("myusername");
    session_register("mypassword");
    setcookie("usuario", $nombre, time() + (3600 * 24)); //Cookie por 1 día
    header("location:main.php");
} else {
    echo "Usuario o password incorrecto";
    header("Refresh: 3; url=index.html");
}
$db->closeConnection();
?>