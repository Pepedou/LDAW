{include file="../header.tpl" title="Altas"}
{include file="../Despachos/Funciones_Ajax.tpl"}


</head>
<body onload="llenaDespachos();llenaEntidad('clientes','Clientes','nombre');">
        {include file="../body_css.tpl"} 
    <h1>{$header}</h1> 

     <form action='altas.php' method='get'>

        {include file="./campos_input.tpl"}
        
    </form>
        {include file="../body_footer.tpl"}
</html>