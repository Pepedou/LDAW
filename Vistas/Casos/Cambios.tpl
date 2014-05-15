{include file="../header.tpl" title="Despachos"}
{include file="../Despachos/Funciones_Llena.tpl"}
{include file="../Despachos/Funciones_Ajax.tpl"}
</head>
<body onload="llenaDespachos(); llenaEntidad('clientes','Clientes','nombre');llenaEntidad('{$name}','{$tabla}','{$campo}');sel({$sel_desp},'despachos');sel({$sel},'{$name}');sel({$sel_status},'status');sel({$sel_cliente},'clientes');">
    {include file="../body_css.tpl"}
    {include file="../select_entidad.tpl"}

    <!-- Desplegar campos correspondientes a actualizar-->
    <form id="campos" name="forma_campos" action='cambios.php'>

        {include file="./campos_input.tpl"}
    </form>
    {include file="../body_footer.tpl"}
</body>
</html>