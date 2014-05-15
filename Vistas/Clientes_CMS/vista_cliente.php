<?php

session_start();
if (!session_is_registered(myusername)) {
    header("Location: index.html");
}

include_once '../../Clases/Cliente.php';



$correo = $_COOKIE['usuario'];
$miUsuario = new Cliente();
$miUsuario->cargarDeBD("email", $correo);

print "
<!DOCTYPE html>
<html><!DOCTYPE html>
<html>
    <head>
        <title>Gesti&oacute;n de Despachos</title>
        <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">

        <script src=\"http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js\"></script>
        <link rel=\"stylesheet\" href=\"../../css/style.css\" type=\"text/css\" media=\"all\" />
        <script type=\"text/javascript\" src=\"../../js/jquery-1.4.2.min.js\"></script>
        <script src=\"../../js/Vistas/Cliente/menu.js\"></script> 

    </head>

    <body onload=\"getUserData('".$miUsuario->atributos['email']."')\">


        <!-- START PAGE SOURCE -->
        <div id=\"shell\">
            <div id=\"header\">
                <h1 id=\"logo\"><a href=\"vista_cliente.php\">GESTION DE DESPACHOS</a></h1>
                <div id=\"navigation\"> <!-- pestañas -->
                         <ul>
                         <li><a href=\"../logout.php\">Cerrar sesión</span></a></li>
                         </ul>
                </div>
                <div id=\"sub-navigation\">
                    <div id =\"bienvenida\" class=\"head\">
                        <ul>
                            <li><a href=\"#\">BIENVENIDO ". $miUsuario->atributos['nombre'] ."</a></li>
                        </ul>
                        
                    </div>
                    <div id=\"search\">
                        <form action=\"#\" method=\"get\" accept-charset=\"utf-8\">        
                        </form>
                    </div>
                </div>

            </div>
            <div id=\"main\">
                <div id=\"content\">
                    <div class=\"box\">
                        <div class=\"head\">
                            <h2></h2>       
                        </div>

                        <div class=\"movie\">
                            <div class=\"movie-image\"> <span class=\"play\"><span class=\"name\">MIS CASOS</span></span><a id=\"refcasos\" href=\"#\"><img src=\"../../css/images/casos.jpg\" alt=\"\"/></a></div>
                            <div id=\"casosref\"class=\"rating\">
                                <a href=\"#\"> CASOS </a>            
                                <span class=\"comments\"></span> </div>
                        </div>

                        <div class=\"movie\">
                            <div class=\"movie-image\"><a id=\"refabogados\" href=\"#\"><img src=\"../../css/images/abogados.jpg\" alt=\"\" /></a> </div>
                            <div id=\"abogadosref\" class=\"rating\">
                                <a href=\"#\"> ABOGADOS</a>      
                                <span class=\"comments\"></span> </div>
                        </div>

                        <div class=\"movie\">
                            <div class=\"movie-image\"> <span class=\"play\"><span class=\"name\">MIS PAGOS</span></span><a id=\"refpagos\" href=\"#\"><img src=\"../../css/images/pagos.jpg\" alt=\"\"/></a></div>
                            <div id=\"pagosref\" class=\"rating\">  
                                <a href=\"#\"> PAGOS </a>            
                                <span class=\"comments\"></span> </div>
                        </div>
                        <div class=\"cl\">&nbsp;</div>
                    </div>


                </div>


                <div class=\"cl\">&nbsp;</div>
            </div>
            <div id=\"footer\">
                <p class=\"lf\"></p>
                <p class=\"rf\"><a></a></p>
                <div style=\"clear:both;\"></div>
            </div>
        </div>
        <!-- END PAGE SOURCE -->

    </body>
</html>


";