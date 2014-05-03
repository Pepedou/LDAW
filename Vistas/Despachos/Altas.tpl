{include file="../header.tpl" title="Altas"}
{include file="./Funciones_Ajax.tpl"}

</head>
<body onload="llenaEstados();llenaEntidad('{$name}','{$tabla}','{$campo}');">
    <h1>Despachos</h1>    
    <form action='altas.php' method='get'>

        {include file="./campos_input.tpl"}
        
    </form>
</body>
</html>


