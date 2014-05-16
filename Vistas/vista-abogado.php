<?php

session_start();
if (!session_is_registered(myusername)) {
    header("Location: ../index.html");
}

include_once '../Clases/Abogado.php';
include_once '../Clases/AbogadosCasos.php';
include_once '../Clases/AbogadosClientes.php';


$correo = $_COOKIE['usuario'];
$miUsuario = new Abogado();
$miUsuario->cargarDeBD("email", $correo);
if ($miUsuario->atributos['id'] == -1)
    die("Ocurrió un error al obtener el usuario.");

print "
<!DOCTYPE html>
<html><head data-gwd-animation-mode=\"proMode\"><meta name=\"GCD\" content=\"YTk3ODQ3ZWZhN2I4NzZmMzBkNTEwYjJl2346eb3881df112d22a38bdd2be9226e\"/>
     <title>Gesti&oacute;n de Despachos</title>
     <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">
     <link rel=\"stylesheet\" href=\"../css/style.css\" type=\"text/css\" media=\"all\" />
     <link rel=\"stylesheet\" href=\"../css/style_details.css\" type=\"text/css\" media=\"all\" />
     <link rel=\"stylesheet\" type=\"text/css\" href=\"../css/dataTables/jquery.dataTables.css\">
     
    <meta name=\"generator\" content=\"Google Web Designer 1.0.5.0416\">    
    <style type=\"text/css\">html, body {
  width: 100%;
  height: 100%;
  margin: 0px;
}

body {
  background-color: transparent;
  -webkit-transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1);
  -moz-transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1);
  transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1);
  -webkit-perspective: 1400px;
  -moz-perspective: 1400px;
  perspective: 1400px;
  -webkit-transform-style: preserve-3d;
  -moz-transform-style: preserve-3d;
  transform-style: preserve-3d;
}

.gwd-div-4mle {
  position: absolute;
  padding-bottom: 0px;
  border-width: 5px;
  border-style: solid;
  width: 15%;
  height: 100%;
  -webkit-transform-origin: 123.5573041836px 332.9652085745px 0px;
  -moz-transform-origin: 123.5573041836px 332.9652085745px 0px;
  transform-origin: 123.5573041836px 332.9652085745px 0px;
  -webkit-transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1);
  -moz-transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1);
  transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1);
  left: 0px;
  top: 15%;
}

.gwd-div-rjvq {
  position: absolute;
  padding-left: 0px;
  padding-right: 0px;
  width: 100%;
  border-width: 5px;
  border-style: solid;
  height: 15%;
  -webkit-transform-origin: 763.5px 63.5px 0px;
  -moz-transform-origin: 763.5px 63.5px 0px;
  transform-origin: 763.5px 63.5px 0px;
  -webkit-transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1);
  -moz-transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1);
  transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1);
  left: 2.308468411516742px;
  top: 1.3845697482792474px;
}

.gwd-div-7t0n {
  position: absolute;
  width: 100%;
  height: 100%;
  border-width: 5px;
  border-style: solid;
  -webkit-transform-origin: 665.4132070832px 333.9941162866px 0px;
  -moz-transform-origin: 665.4132070832px 333.9941162866px 0px;
  transform-origin: 665.4132070832px 333.9941162866px 0px;
  -webkit-transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1);
  -moz-transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1);
  transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1);
  left: 15%;
  top: 15%;
}

.gwd-div-2osj {
  position: absolute;
  width: 9.0049894351px;
  height: 7.9903655519px;
  left: 1153.7560452847px;
  top: 573.9116278742px;
}

.gwd-div-mxuu {
  position: absolute;
  width: 292px;
  height: 88px;
  left: 15px;
  top: 15px;
}

.gwd-img-zvzd {
  position: absolute;
  width: 292px;
  height: 88px;
  -webkit-transform-origin: 114px 58px 0px;
  -moz-transform-origin: 114px 58px 0px;
  transform-origin: 114px 58px 0px;
  -webkit-transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1);
  -moz-transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1);
  transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1);
  left: 0px;
  top: 0px;
}

.gwd-div-lim3 {
  position: relative;
  width: auto;
  -webkit-transform: matrix3d(0.9999550804, 0.0094782472, 0, 0, -0.0094782472, 0.9999550804, 0, 0, 0, 0, 1, 0, 0.1706084496, 0.0008085528, 0, 1);
  -moz-transform: matrix3d(0.9999550804, 0.0094782472, 0, 0, -0.0094782472, 0.9999550804, 0, 0, 0, 0, 1, 0, 0.1706084496, 0.0008085528, 0, 1);
  transform: matrix3d(0.9999550804, 0.0094782472, 0, 0, -0.0094782472, 0.9999550804, 0, 0, 0, 0, 1, 0, 0.1706084496, 0.0008085528, 0, 1);
  -webkit-transform-style: preserve-3d;
  -moz-transform-style: preserve-3d;
  transform-style: preserve-3d;
  height: 30px;
  top: 20px;
  left: 5px;
}

.gwd-div-xrkl {
  font-family: 'Courier New';
  color: rgb(0, 0, 0);
  position: relative;
  width: auto;
  height: auto;
  left: 0px;
  top: 0px;
  text-align: center;
}

.gwd-div-bx6z {
  text-align: center;
}

.gwd-span-xmh2 {
  font-family: 'Courier New';
  font-size: 30px;
}

.gwd-div-l46c {
  width: auto;
  font-family: 'Courier New';
  color: rgb(0, 0, 0);
  position: relative;
  height: 40px;
  left: 5%;
  top: 30%;
  text-align: center;
}
.gwd-div-ub98 {
  position: absolute;
  font-family:'Courier New';
  text-align: left;
  width: 187px;
  height: 34px;
  -webkit-transform-origin: 93.5px 17px 0px;
  -webkit-transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1);
  left: 1307px;
  top: 41px;
}

.gwd-span-dpjp {
  font-family: 'Courier New';
  font-size: 40px;
}

</style>
  </head>
  
  <body>
  <div id=\"shell\">
    <div id=\"header\">
     <h1 id=\"logo\"><a href=\"../Vistas/vista-admin.php\">GESTION DE DESPACHOS</a></h1>
      <div id=\"navigation\">
      <ul>
      <li><a href=\"#\">BIENVENIDO  Administrador " . $miUsuario->atributos['nombre'] . "</a></li>
       
       </ul>
       <ul>
       <li><a href=\"logout.php\">Cerrar sesión</span></a></li>
       </ul>
       </div> <!--End Navigation-->
    </div> <!--End Header-->
    <div class=\"gwd-div-4mle\" id=\"leftnav\">
      <div class=\"gwd-div-lim3 menuEntry\" id=\"menu_entry1\">
        <div class=\"gwd-div-bx6z\"><span class=\"gwd-span-xmh2\">Casos</span>

        </div>
      </div>
      <br>
      
      <div class=\"gwd-div-lim3 menuEntry\" id=\"menu_entry2\">
        <div class=\"gwd-div-bx6z\"><span class=\"gwd-span-xmh2\">Clientes</span>

        </div>
      </div>
      <br>
      
      <div class=\"gwd-div-lim3 menuEntry\" id=\"menu_entry3\">
        <div class=\"gwd-div-bx6z\"><span class=\"gwd-span-xmh2\">Mi Despacho</span>

        </div>
      </div>
      <br>
      
      <div class=\"gwd-div-lim3 menuEntry\" id=\"menu_entry4\">
        <div class=\"gwd-div-bx6z\"><span class=\"gwd-span-xmh2\">Tareas</span>

        </div>
      </div>
      <br>
      
      <div class=\"gwd-div-lim3 menuEntry\" id=\"menu_entry5\">
        <div class=\"gwd-div-bx6z\"><span class=\"gwd-span-xmh2\">Honorarios</span>

        </div>
      </div>
      <br>
      
      <div class=\"gwd-div-lim3 menuEntry\" id=\"menu_entry6\">
        <div class=\"gwd-div-bx6z\"><span class=\"gwd-span-xmh2\">Reportes</span>

        </div>
      </div>
      <br>
    </div>
    
    <div id=\"main\">
     <div id=\"content\">
        <div id =\"main_content\">
            <div class=\"box\">
                </div>     

                </div>
    </div>
    <div class=\"gwd-div-2osj\"></div>
    
    
  
<userTag uid=\"" . $miUsuario->atributos['id'] . "\" nombre=\"" . $miUsuario->atributos['nombre'] . "\" apellidoP=\"" . $miUsuario->atributos['apellidoP'] . "\" apellidoM=\"" . $miUsuario->atributos['apellidoM'] . "\" id_Despacho=\"" . $miUsuario->atributos['id_Despacho'] . "\"/>
</body>
<script src=\"http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js\"></script>
<script src=\"../js/vista-abogado.js\"></script>
<script type=\"text/javascript\" language=\"javascript\" src=\"../js/dataTables/jquery.dataTables.js\"></script>
</html>
";
