{include file="../header.tpl" title="Altas"}
{include file="../Despachos/Funciones_Ajax.tpl"}

</head>
<body onload="llenaEntidad('expedientes','Expedientes','nombre');
        llenaTipos();">
    <h1>{$header}</h1>    
    <form action='altas.php' method='post' enctype="multipart/form-data">

        {include file="./campos_input.tpl"}
        
    </form>
</body>
</html>