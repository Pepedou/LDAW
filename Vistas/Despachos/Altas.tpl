{include file="../header.tpl" title="Altas"}
{include file="./Funciones_Ajax.tpl"}
{include file="../validaciones.tpl"}

</head>
<body onload="llenaEstados();llenaEntidad('{$name}','{$tabla}','{$campo}');">
 {include file="../body_css.tpl"}
    <h1>Despachos</h1>    
    <form id="forma_entidad" action='altas.php' method='get'>

        {include file="./campos_input.tpl"}
        
    </form>
        {include file="../body_footer.tpl"}
</body>
</html>


