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
<html>
     <head>
        <title>Gesti&oacute;n de Despachos</title>
        
        
         <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">
              
         
         <script type=\"text/javascript\" src=\"http://code.jquery.com/jquery-1.10.2.min.js\"></script>
         
         <link rel=\"stylesheet\" href=\"../css/style.css\" type=\"text/css\" media=\"all\" />
         <link rel=\"stylesheet\" href=\"../css/style_details.css\" type=\"text/css\" media=\"all\" />
         <link rel=\"stylesheet\" type=\"text/css\" href=\"../css/dataTables/jquery.dataTables.css\">
         <link rel=\"stylesheet\" type=\"text/css\" href=\"../css/google_css.css\">
	 
  
    </head>

    <body>

<div id=\"shell\">
  <div id=\"header\">
    <h1 id=\"logo\"><a href=\"../Vistas/vista-abogado2.php\">GESTION DE DESPACHOS</a></h1>
    <div id=\"navigation\">
      <ul>
      <li><a href=\"#\">BIENVENIDO(A)  Abogado(a) " . $miUsuario->atributos['nombre'] . "</a></li>
       
     </ul>
     <ul>
     <li><a href=\"logout.php\">Cerrar sesión</span></a></li>
     </ul>
    </div>
    <div id=\"sub-navigation\">
  
    </div>
    

  <div id=\"main\">
    <div id=\"content\">
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
<div id =\"main_content_abogs\">
        <div class=\"box\">
        <div class=\"head\">
          <h2></h2>       
        </div>       
        
        <div class=\"cl\">&nbsp;</div>
      </div>
   </div>
    
  </div>
        
   
    </div>
    <div id=\"news\">
      <div class=\"head\">
        <h3></h3>
        <p class=\"text-right\"><a href=\"#\"></a></p>
      </div>
      <div class=\"content\">
       
      </div>
    <div id=\"coming\">
      <div class=\"head\">
        
      </div>
     
    <div class=\"cl\">&nbsp;</div>
  </div>
  <div id=\"footer\">
    <p class=\"lf\">Copyright &copy; 2010 <a href=\"#\"></a> - All Rights Reserved</p>
    <p class=\"rf\"></p>
    <div style=\"clear:both;\"></div>
  </div>
</div>
<!-- END PAGE SOURCE -->
<userTag uid=\"" . $miUsuario->atributos['id'] . "\" nombre=\"" . $miUsuario->atributos['nombre'] . "\" apellidoP=\"" . $miUsuario->atributos['apellidoP'] . "\" apellidoM=\"" . $miUsuario->atributos['apellidoM'] . "\" id_Despacho=\"" . $miUsuario->atributos['id_Despacho'] . "\"/>
</body>
<script src=\"http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js\"></script>
<script src=\"../js/highcharts.js\"></script>
<script src=\"../js/vista-abogado.js\"></script>
<script type=\"text/javascript\" language=\"javascript\" src=\"../js/dataTables/jquery.dataTables.js\"></script>
</html> 
         
";



