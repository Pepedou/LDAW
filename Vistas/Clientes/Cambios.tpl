{include file="../header.tpl" title="Despachos"}
{include file="../Despachos/Funciones_Llena.tpl"}
{include file="../Despachos/Funciones_Ajax.tpl"}
</head>
<body onload="llenaEstados();llenaMunicipios({$sel_edo});llenaEntidad('{$name}','{$tabla}','{$campo}');selected_direccion({$sel_edo},{$sel_mun});select_entidad({$sel},'{$name}');">

      <h1>Actualiza {$tabla}</h1>        

        <td >
            <label for="{$name}">{$nombre_titulo}</label>
            <select id="{$name}" name ="{$name}" selected="{$sel}" onchange='actualiza(this);'>
            </select>
        </td>

    <!-- Desplegar campos correspondientes a actualizar-->
    <form action=''>
        {include file="./campos_input.tpl"}
    </form>

</body>
</html>