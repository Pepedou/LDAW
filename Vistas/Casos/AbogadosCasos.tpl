{include file="../header.tpl" title="Altas"}
{include file="../Despachos/Funciones_Ajax.tpl"}
{include file="./funciones_check.tpl"}

{block name='head'} 
    <link rel="stylesheet" type="text/css" href="css/dataTables/jquery.dataTables.css">
    <link rel="stylesheet" href="css/style_details.css" type="text/css" media="all" />
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" language="javascript" src="js/dataTables/jquery.dataTables.js"></script>
{/block}
</head>
<body onload="llenaAbogadosDespachos({$id_desp});">
    {include file="../body_css.tpl"} 
    <h1 style="margin-left:20%;">Asignar Abogados al Caso {$caso_name}</h1> 
    <input type ='hidden' id="id_caso" name='id_caso' value="{$caso_id}"/>
    <div id="abogados_desp" style="width: 40%;margin-left:30%;"> </div>
    <button style="margin-left:75%;" onclick="check()">Registar</button>
    {include file="../body_footer.tpl"}
</html>