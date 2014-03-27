{include file="./header.tpl" title="Altas"}
</head>
<body>
    <h1>{$nombre}</h1>    
    <form action='altas.php' method='get'>
        {foreach from=$data item=entry}

            <table>            
                <tr>
                    <td>
                        <input type='text' name= {$entry} />

                    </td>
                </tr>
                {include file="./Forma_alta.tpl"}
                
            </table>

        {/foreach}
    </form>
</body>
</html>