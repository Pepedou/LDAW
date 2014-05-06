{include file="../header.tpl" title="Despachos"}
{include file="../Despachos/Funciones_Llena.tpl"}
{include file="../Despachos/Funciones_Ajax.tpl"}
</head>
<body onload="llenaDespachos(); llenaRoles(); llenaEntidad('{$name}','{$tabla}','{$campo}');sel({$sel_rol},'roles');sel({$sel_desp},'despachos');sel({$sel},'{$name}');">
{include file="../select_entidad.tpl"}

    <!-- Desplegar campos correspondientes a actualizar-->
    <form id="campos" name="forma_campos" action='cambios.php'>

        {include file="./campos_input.tpl"}
    </form>

</body>
</html>