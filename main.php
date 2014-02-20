<?php
session_start();
if (!session_is_registered(myusername)) {
    header("Location: index.html");
}
include './Abogado.php';
$nombreUsuario = $_COOKIE['usuario'];
$miUsuario = new Abogado();
$miUsuario->cargarUsuarioDeBD($nombreUsuario);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--
Design by Free CSS Templates
http://www.freecsstemplates.org
Released for free under a Creative Commons Attribution 2.5 License

Name       : Scenic Office 
Description: A two-column, fixed-width design with dark color scheme.
Version    : 1.0
Released   : 20130602

-->
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Propuesta 2</title>
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
                    <h1><a href="#">LOGO</a></h1></div>
                <div id="menu">
                    <ul>
                        <li class="current_page_item"><a href="#" accesskey="1" title="">Homepage</a></li>
                        <li><a href="generaDespachos.php" accesskey="2" title="">Despachos</a></li>
                        <li><a href="#" accesskey="3" title="">About Us</a></li>
                        <li><a href="logout.php" accesskey="5" title="">Cerrar sesi&oacute;n</a></li>
                    </ul>
                </div>
            </div>
            <div id="page" class="container">
                <div id="content">
                    <div class="article borders">
                        <div class="title">
                            <h2>Bienvenido <?php echo $miUsuario->nombre ?></h2>
                        </div>
                        <table border="0" width="100%">
                            <tr>
                                <td>Herramienta 1<br /><img src="http://lorempixel.com/75/75" /></td>
                                <td>Herramienta 2<br /><img src="http://lorempixel.com/75/75" /></td>
                                <td>Herramienta 3<br /><img src="http://lorempixel.com/75/75" /></td>
                                <td>Herramienta 4<br /><img src="http://lorempixel.com/75/75" /></td>
                                <td>Herramienta 5<br /><img src="http://lorempixel.com/75/75" /></td>
                            </tr>
                        </table>
                        <br />
                        <br />
                        <h3>Despacho 1</h3>
                        <br />
                        <p><a href="#" >Cliente 1. (Casos: caso1, caso2 ...)</a></p>
                        <p><a href="#" >Cliente 2. (Casos: caso1, caso2 ...)</a></p>
                        <p><a href="#" >Cliente 3. (Casos: caso1, caso2 ...)</a></p>
                        <p><a href="#" >Cliente 4. (Casos: caso1, caso2 ...)</a></p>
                        <p><a href="#" >Cliente 5. (Casos: caso1, caso2 ...)</a></p>
                        <p class="links"><a href="#" class="button">Read More</a></p>
                        <br />
                        <br />
                        <h3>Despacho 2</h3>
                        <br />
                        <p><a href="#" >Cliente 1. (Casos: caso1, caso2 ...)</a></p>
                        <p><a href="#" >Cliente 2. (Casos: caso1, caso2 ...)</a></p>
                        <p><a href="#" >Cliente 3. (Casos: caso1, caso2 ...)</a></p>
                        <p><a href="#" >Cliente 4. (Casos: caso1, caso2 ...)</a></p>
                        <p><a href="#" >Cliente 5. (Casos: caso1, caso2 ...)</a></p>
                        <p class="links"><a href="#" class="button">Read More</a></p>
                    </div>
                </div>
                <div id="sidebar">
                    <div class="box1">
                        <div class="title">
                            <h2>Inbox</h2>
                        </div>
                        <ul class="style2">
                            <li><a href="#">Correo 1</a></li>
                            <li><a href="#">Correo 2</a></li>
                            <li><a href="#">Correo 3</a></li>
                            <li><a href="#">Correo 4</a></li>
                            <li><a href="#">Correo 5</a></li>
                            <li><a href="#">Correo 6</a></li>
                        </ul>
                    </div>
                    <div class="box2">
                        <div class="title">
                            <h2>Casos recientes</h2>
                        </div>
                        <ul class="style2">
                            <li><a href="#">Caso 1</a></li>
                            <li><a href="#">Caso 2</a></li>
                            <li><a href="#">Caso 3</a></li>
                            <li><a href="#">Caso 4</a></li>
                            <li><a href="#">Caso 5</a></li>
                            <li><a href="#">Caso 6</a></li>
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