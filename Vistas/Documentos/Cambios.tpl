{include file="../header.tpl" title="Despachos"}
{include file="./FuncionesDocumentos.tpl"}

</head>
<!--<body onload="llenaTipos();llenaEntidad('expedientes','Expedientes','expedientes');llenaEntidad('{$name}','{$tabla}','{$campo}');">-->
<body >

 <h1>Lista de {$tabla}</h1>        

   <!--<td >
        <label for="{$name}">{$nombre_titulo}</label>
        <select id="{$name}" name ="{$name}" selected="{$sel}" onchange="actualiza(this);">
        </select>
    </td> -->

    <!-- Desplegar campos correspondientes a actualizar-->
    <!-- <form id="campos" name="forma_campos" action='cambios.php'>-->

        {include file="./campos_input2.tpl"}
    <!--</form>-->

</body>
</html>