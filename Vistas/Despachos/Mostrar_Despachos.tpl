{include file="../header.tpl" title="Despachos"}
</head>
<body>
    <h1>{$nombre}</h1>    
    <form action='altas.php' method='get'>

     <!-- Select-->
     {html_options name=opciones options=$opciones selected=$select}

    </form>
    </body>
</html>