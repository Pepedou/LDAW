<?php
session_start();
if (!session_is_registered(myusername)) {
    header("Location: index.html");
}
include_once './Clases/Abogado.php';
include_once './Clases/AbogadosCasos.php';
include_once './Clases/AbogadosClientes.php';
$nombreUsuario = $_COOKIE['usuario'];
$miUsuario = new Abogado();
$aux2 = new AbogadosCasos();
$aux = new AbogadosClientes();
$exito = $miUsuario->cargarDeBD("email", $nombreUsuario);
$aux->guardarDatos(array(
    "id_Abogado" => $miUsuario->atributos['id']
));
$aux2->guardarDatos(array(
    "id_Abogado" => $miUsuario->atributos['id']
));
$casos = $aux->cargarCasos();
$clientes = $aux2->cargarClientes();
$debug = Debug::getInstance();
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Gesti&oacute;n de Despachos</title>
        <meta name="keywords" content="" />
        <meta name="description" content="" />
        <link href="css/default.css" rel="stylesheet" type="text/css" media="all" />
        <link href="css/fonts.css" rel="stylesheet" type="text/css" media="all" />
        <!--[if IE 6]>
        <link href="default_ie6.css" rel="stylesheet" type="text/css" />
        <![endif]-->
    </head>
    <body>
        <div id="wrapper">
            <div id="header" class="container">
                <div id="logo">
                    <h1><a href="#">GESTION DESPACHOS</a></h1></div>
                <div id="menu">
                    <ul>
                        <li class="current_page_item"><a href="main.php" accesskey="1" title="">Inicio</a></li>
                        <li><a href="logout.php" accesskey="2" title="">Cerrar sesi&oacute;n</a></li>
                    </ul>
                </div>
            </div>
            <div id="page" class="container">
                <div id="content">
                    <div class="article borders">
                        <div class="title">
                            <h2>Bienvenido <?php
                                if ($exito)
                                    echo $miUsuario->atributos['nombre'];
                                else
                                    echo "Usuario(a)";
                                ?></h2>
                        </div>
                        <h3>Administrar</h3>
                        <table style="text-align: center;" border="0" width="100%">
                            <tr>
                                <td><a href="./Vistas/Despachos/opciones.html">Despachos<br /><img src="http://www.clker.com/cliparts/D/o/j/l/l/K/plain-house-th.png" /></a></td>
                                <td><a href="./Vistas/Clientes/opciones.html">Clientes<br /><img src="http://rryt.mx/wp-content/uploads/2012/06/clientes.jpg" /></a></td>
                                <td><a href="./Vistas/Abogados/opciones.html">Abogados<br /><img src="http://img.classistatic.com/crop/50x50/i.ebayimg.com/00/s/NjI1WDkzOQ==/z/KDkAAOxyni9TEVXM/$_14.JPG" /></a></td>
                                <td><a href="./Vistas/Casos/opciones.html">Casos<br /><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/c6/Seal_of_the_National_Guard_Bureau_(US).svg/100px-Seal_of_the_National_Guard_Bureau_(US).svg.png" /></a></td>
                                <td><a href="./Vistas/Expedientes/opciones.html">Expedientes<br /><img src="http://www.dgfc.sgpg.meh.es/sitios/dgfc/es-ES/ipr/ir/cete/PublishingImages/ConsultaExpedientes.gif" /></a></td>
                            </tr>
                            <br/>
                            <br/>
                            <tr>
                                <td><a href= "./Vistas/Pagos/opciones.html">Pagos<br /><img src="http://www.credencial.mx/example/bancos.png" /></a></td>
                                <td><a href= "./Vistas/Tareas/opciones.html">Tareas<br /><img src="http://www.simon-bolivar.edu.mx/images/tareas_840pv6z6.png" /></a></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div id="sidebar">
                    <div class="box1">
                        <div class="title">
                            <h2>Mis casos</h2>
                        </div>
                        <ul class="style2">
                            <?php
                            foreach ($casos as $caso) {
                                print "<li>" . $caso->atributos['nombre'] . "</li>";
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="box2">
                        <div class="title">
                            <h2>Mis clientes</h2>
                        </div>
                        <ul class="style2">
                            <?php
                            foreach ($clientes as $cliente) {
                                print "<li>" . $cliente->atributos['nombre'] . " " . $cliente->atributos['apellidoP'] . " " . $cliente->atributos['apellidoM'] . "</li>";
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div id="copyright" class="container">
            <p>Copyright (c) 2014 Sitename.com. All rights reserved. | Photos by <a href="http://fotogrph.com/">Fotogrph</a> | Design by <a href="http://www.freecsstemplates.org/" rel="nofollow">FreeCSSTemplates.org</a>.</p>
        </div>
    </body>
</html>