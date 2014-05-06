{include file="../header.tpl" title="Altas"}
{include file="../Despachos/Funciones_Ajax.tpl"}

</head>
<body onload="llenaEntidad('clientes','Clientes','nombre');">
    <h1>{$header}</h1>    
    <form action='altas.php' method='get'>

        {include file="./campos_input.tpl"}
        
    </form>
</body>
</html>


