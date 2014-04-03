{include file="../header.tpl" title="Altas"}
{include file="../Despachos/Funciones_Ajax.tpl"}

</head>
<body onload="llenaDespachos();
        llenaRoles();">

    {include file="../Forma_alta.tpl"}
    <table>
        <td >
            <label for="despachos">Despacho</label>
            <select id="despachos" name ="id_Despacho">
            </select>
        </td>
        <td >
            <label for="roles">Rol</label>
            <select id="roles" name ="id_Rol">
            </select>
        </td>
</table>

        <td>
            <input type='submit' value='Registrar' />
        </td>
    
</form>
</body>
</html>