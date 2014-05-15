<?php

session_start();
if (!session_is_registered(myusername)) {
    header("Location: index.html");
}

include_once '../Clases/Abogado.php';
include_once '../Clases/AbogadosCasos.php';
include_once '../Clases/AbogadosClientes.php';


$correo = $_COOKIE['usuario'];
$miUsuario = new Abogado();
$miUsuario->cargarDeBD("email", $correo);

print"
<!DOCTYPE html>
<html>
     <head>
        <title>Gesti&oacute;n de Despachos</title>
        
        
         <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">
              
         
         <script type=\"text/javascript\" src=\"http://code.jquery.com/jquery-1.10.2.min.js\"></script>
         
         <link rel=\"stylesheet\" href=\"../css/style.css\" type=\"text/css\" media=\"all\" />
         <link rel=\"stylesheet\" href=\"../css/style_details.css\" type=\"text/css\" media=\"all\" />
         <link rel=\"stylesheet\" type=\"text/css\" href=\"../css/dataTables/jquery.dataTables.css\">
		
		
        <script src=\"../js/Vistas/admin_menu.js\"></script> 
        <script type=\"text/javascript\" language=\"javascript\" src=\"../js/dataTables/jquery.dataTables.js\"></script>
  
    </head>

    <body>

<div id=\"shell\">
  <div id=\"header\">
    <h1 id=\"logo\"><a href=\"../Vistas/vista-admin.php\">GESTION DE DESPACHOS</a></h1>
    <div id=\"navigation\">
      <ul>
      <li><a href=\"#\">BIENVENIDO  " . $miUsuario->atributos['nombre'] . "</a></li>
       
     </ul>
     <ul>
     <li><a href=\"logout.php\">Cerrar sesión</span></a></li>
     </ul>
    </div>
    <div id=\"sub-navigation\">
     <div id =\"bienvenida\" class=\"head\">
      <ul>        
      <li><a id=\"home\" class=\"active\" href=\"#\">HOME</a></li>
      <li><a id=\"navAbogados\" href=\"#\">ABOGADOS</a></li>
      <li><a id=\"navCasos\" href=\"#\">CASOS</a></li>
      <li><a id=\"navDespachos\" href=\"#\">DESPACHOS</a></li>
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
      
        <div id =\"main_content\">
        <div class=\"box\">
        <div class=\"head\">
          <h2></h2>       
        </div>
        <div class=\"movie\">
          <div class=\"movie-image\"> <span class=\"play\"><span class=\"name\">MIS CASOS</span></span><a id=\"refcasos\" href=\"#\"><img src=\"../css/images/casos.jpg\" alt=\"\"/></a></div>
          <div id=\"casosref\"class=\"rating\">
            <a href=\"#\"> CASOS </a>            
            <span class=\"comments\"></span> </div>
        </div>
        
        <div class=\"movie\">
          <div class=\"movie-image\"><a id=\"refabogados\" href=\"#\"><img src=\"../css/images/abogados.jpg\" alt=\"\" /></a> </div>
          <div id=\"abogadosref\" class=\"rating\">
           <a href=\"#\"> ABOGADOS</a> 
          <span class=\"comments\"></span> </div>
        </div>
        
        <div class=\"movie\">
          <div class=\"movie-image\"> <span class=\"play\"><span class=\"name\">MIS PAGOS</span></span><a id=\"refpagos\" href=\"#\"><img src=\"../css/images/pagos.jpg\" alt=\"\"/></a></div>
          <div id=\"pagosref\" class=\"rating\">  
          	 <a href=\"#\"> PAGOS </a>     
                 <a href=\"../altas.php?op=Pago\">Registar</a>
                 
            <span class=\"comments\"></span> </div>
        </div>
        <div class=\"cl\">&nbsp;</div>
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
    <p class=\"rf\"><a href=\"http://www.free-css.com/\"></a> by <a href=\"http://chocotemplates.com/\">ChocoTemplates.com</a></p>
    <div style=\"clear:both;\"></div>
  </div>
</div>
<!-- END PAGE SOURCE -->

</body>
</html> 
         
";



