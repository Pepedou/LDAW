{include file="../header.tpl" title="Despachos"}
{include file="./Funciones_Llena.tpl"}
{include file="./Funciones_Ajax.tpl"}
</head>
<body onload="llenaDespachos(); llenaEstados(); llenaMunicipios({$sel_edo});selected_direccion({$sel_edo},{$sel_mun});select_entidad({$sel},'{$name}');">
     {include file="../body_css.tpl"}
    <h1>{$nombre}</h1>        

        <td >
            <label for="despachos">Despacho</label>
            <select id="despachos" name ="id_Despacho" selected="{$sel}" onchange='actualiza(this);'>
            </select>
        </td>

    <!-- Desplegar campos correspondientes a actualizar-->
    <form id="campos" name="forma_campos" action='cambios.php'>

        {include file="./campos_input.tpl"}
    </form>
{include file="../body_footer.tpl"}
</body>
</html>