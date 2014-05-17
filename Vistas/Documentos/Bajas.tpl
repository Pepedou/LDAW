{include file="../header.tpl" title="Despachos"}
{include file="../Despachos/Funciones_Llena.tpl"}
{include file="../Despachos/Funciones_Ajax.tpl"}
</head>
<body onload="llenaEntidad('{$name}','{$tabla}','{$campo}');">
    {include file="./header_doc.tpl"}
    <h1>Elimina {$tabla}</h1>        

        <td >
            <label for="{$name}">{$nombre_titulo}</label>
            <select id="{$name}" name ="{$name}" selected="{$sel}" onchange="nombre_desp(this);">
            </select>
        </td>

    <!-- Desplegar campos correspondientes a actualizar-->
    <form action=''>
        {include file="./campos_text.tpl"}
    </form>
{include file="../body_footer.tpl"}
</body>
</html>