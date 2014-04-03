{include file="../header.tpl" title="Despachos"}
{include file="../Despachos/Funciones_Llena.tpl"}
{include file="../Despachos/Funciones_Ajax.tpl"}
</head>
<body onload="llenaEntidad('casos','Casos','nombre');llenaEntidad('{$name}','{$tabla}','{$campo}');">
    
    <h1>Actualiza {$tabla}</h1>        

        <td >
            <label for="{$name}">{$nombre_titulo}</label>
            <select id="{$name}" name ="{$name}" selected="{$sel}" onchange="actualiza(this);">
            </select>
        </td>

    <!-- Desplegar campos correspondientes a actualizar-->
    <form id="campos" name="forma_campos" action='cambios.php'>

        {include file="./campos_input.tpl"}
    </form>

</body>
</html>