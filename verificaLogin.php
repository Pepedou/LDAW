<!-- verificacion de usuario -->
<?php
//php5 ob_start();
$host = "localhost"; // Host
$username = "1015544_user"; // usuario mysql
$password = "1015544"; // password
$db_name = "ldaw_1015544"; // Database
$tbl_name = "Usuarios"; // tabla
// nos conectamos a la BD
$enlace = mysql_connect("$host", "$username", "$password") or die("No puedo conectarme");
mysql_select_db("$db_name") or die("No puedo seleccionar la DB");

// cachamos usuario y password
$myusername = $_POST['usuario'];
$mypassword = $_POST['pwd'];

// Para eliminar posibles inyecciones a MySQL
$myusername = stripslashes($myusername);
$mypassword = stripslashes($mypassword);
$myusername = mysql_real_escape_string($myusername);
$mypassword = mysql_real_escape_string($mypassword);

$sql = "SELECT * FROM $tbl_name WHERE usuario='$myusername' and pwd=sha1('$mypassword')";

$result = mysql_query($sql);

$fila = mysql_fetch_array($result, MYSQL_ASSOC);

$nombre = $fila['nombre'];

// Contamos las lineas regresadas por el query
$count = mysql_num_rows($result);

mysql_free_result($resultado);

mysql_close($enlace);

// Si el resultado hace match $myusername y $mypassword, nos debe de regrasar 1
if ($count == 1) {
    // Registramos $myusername, $mypassword y redireccionamos a "login_exitoso.php"
    session_register("myusername");
    session_register("mypassword");
    setcookie("usuario", $nombre, time() + (3600 * 24)); //Cookie por 1 día
    header("location:main.php");
} else {
    echo "Usuario o password incorrecto";
}
?>