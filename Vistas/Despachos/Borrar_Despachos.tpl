{php}  
if(isset($_REQUEST['nombre'])){
    
    $desp = new Despacho();
    $exito = $desp->cargarDeBD("nombre", $_REQUEST['nombre']);
    if ($exito){ Debug::getinstance()->alert("Despacho Cargado:");}
    //echo $desp->nombre;
    $dir = new Direccion();
    $exito2 = $dir->cargarDeBD("id",$desp->atributos['id_Direccion']);
    if ($exito2){ Debug::getinstance()->alert("Direccion Cargado"); }
} 
{/php}

{include file="../header.tpl" title="Despachos"}
{include file="./Funciones_Llena.tpl"}
</head>
<body onload="show(1);">
    <h1>{$nombre}</h1>    
    <form action='retrieve.php' method='get'>

        <!-- Select-->
        {html_options name=opciones options=$opciones selected=$select onchange="show(1);nombre_desp(this);"}

    </form>
    <!-- Desplegar campos correspondientes del despacho a borrar-->
    <form id="campos" name="forma_campos" action='bajas.php?nombre='>

        {include file="./campos_text.tpl"}
    </form>

</body>
</html>