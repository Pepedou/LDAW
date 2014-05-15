{include file="../header.tpl" title="Despachos"}
{include file="./Funciones_Llena.tpl"}
{include file="./Funciones_Ajax.tpl"}
</head>
<body onload="llenaEntidad('{$name}','{$tabla}','{$campo}');">
     {include file="../body_css.tpl"}
    <h1>Elimina {$tabla}</h1>        

        <td >
            <label for="{$name}">{$nombre_titulo}</label>
            <select id="{$name}" name ="{$name}" selected="{$sel}" onchange="nombre_desp(this);">
            </select>
        </td>
        
    <!-- Desplegar campos correspondientes del despacho a borrar-->
    
         
        {include file="./campos_text.tpl"}
  
{include file="../body_footer.tpl"}
</body>
</html>