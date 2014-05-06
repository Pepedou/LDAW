{include file="../header.tpl" title="Altas"}
{include file="../Despachos/Funciones_Ajax.tpl"}


</head>
<body onload="llenaEntidad('abogados','Abogados','nombre');llenaEntidad('casos','Casos','nombre');">
     <h1>{$header}</h1> 

     <form action='altas.php' method='get'>

        {include file="./campos_input.tpl"}
        
    </form>
</html>