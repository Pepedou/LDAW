{include file="../header.tpl" title="Altas"}
{include file="../Despachos/Funciones_Ajax.tpl"}
{include file="./funciones_check.tpl"}

{block name='head'} 
  <script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
{/block}
</head>
<body onload="llenaAbogadosDespachos({$id_desp});">
    {include file="../body_css.tpl"} 
    <h1>Asignar Abogados al Caso {$caso_name}</h1> 

    <div id="abogados_desp"> </div>
    <button onclick="check()">Registar</button>
    {include file="../body_footer.tpl"}
</html>