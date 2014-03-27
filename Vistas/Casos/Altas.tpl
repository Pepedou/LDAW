{include file="../header.tpl" title="Altas"}
{include file="../Despachos/Funciones_Ajax.tpl"}


</head>
<body onload="llenaDespachos();">

{include file="../Forma_alta.tpl"}

<td >
    <label for="despachos">Despacho</label>
    <select id="despachos" name ="id_Despacho">
    </select>
</td>

<td>
    <input type='submit' value='Registrar' />
</td>

</form>
</body>
</html>