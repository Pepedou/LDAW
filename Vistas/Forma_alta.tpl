{include file="./header.tpl" title="Altas"}
</head>
<body>
    <h1>{$nombre}</h1>    
    <form action='altas.php' method='get'>
        {foreach from=$data item=entry}

            <table>            
                <tr>
                    <td>
                        <label for={$entry@key}>{$entry@key}</label>
                        <input type='text' name= {$entry@key} />

                    </td>
                </tr>
                
                
            </table>

        {/foreach}
  