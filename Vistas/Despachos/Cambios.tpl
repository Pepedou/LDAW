{include file="../header.tpl" title="Despachos"}
{include file="./Funciones_Llena.tpl"}
{include file="./Funciones_Ajax.tpl"}
</head>
<body onload="llenaDespachos()">
    <h1>{$nombre}</h1>    
    <form action='cambios.php' method='get'>

        <td >
            <label for="despachos">Despacho</label>
            <select id="despachos" name ="id_Despacho" onchange='actualiza(this);'>
            </select>
        </td>

    </form>

    <!-- Desplegar campos correspondientes a actualizar-->
    <form id="campos" name="forma_campos" action='bajas.php?nombre='>

        {include file="./campos_input.tpl"}
    </form>

</body>
</html>