{include file="../header.tpl" title="Altas"}
{include file="../Despachos/Funciones_Ajax.tpl"}
{include file="./validacion_abogados.tpl"}

</head>
<body onload="llenaDespachos();llenaRoles();">
    {include file="../body_css.tpl"}
    <h1>{$header}</h1>    
    <form id="forma_verificar" action='#' method='post' enctype="multipart/form-data">

        {include file="./campos_input.tpl"}
        
    </form>
     {include file="../body_footer.tpl"}
</body>
</html>


