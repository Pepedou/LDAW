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