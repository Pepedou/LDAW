{include file="../header.tpl" title="Altas"}
{include file="./Funciones_Ajax.tpl"}

</head>
<body onload="llenaEstados();llenaEntidad('{$name}','{$tabla}','{$campo}');">
 {include file="../body_css.tpl"}
    <h1>Despachos</h1>    
    <form action='altas.php' method='get'>

        {include file="./campos_input.tpl"}
        
    </form>
        {include file="../body_footer.tpl"}
</body>
</html>


