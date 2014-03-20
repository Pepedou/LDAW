{include file="../header.tpl" title="Altas"}
{include file="./Funciones_Ajax.tpl"}

</head>
<body onload="llenaEstados();">
    <h1>Despachos</h1>    
    <form action='altas.php' method='get'>
        <table>            
            <tr>
                <td>
                    <p>Nombre del despacho</p>
                </td>
                <td>
                    <input type='text' name='nombre' />
                   
                </td>
            </tr>
            <tr>
                <td>
                    <p>Dirección del despacho:</p>
                </td>
                <td>
                    <label for="calle">Calle</label>
                    <input type='text' name='calle' />
                     
                </td>
                <td>
                    <label for="colonia">Colonia</label>
                    <input type='text' name='colonia' />
                </td>
                <td >
                    <label for="estados">Estado</label>
                    <select id="estados">
                    </select>
                </td>
                <td>
                    <label for="ciudad">Cd</label>
                    <input type='text' name='ciudad' />
                </td>   
                <td id = municipios>

                </td>
                <td>
                    <label for="cp">cp</label>
                    <input type='text' name='cp' />
                </td>
            </tr>
            <tr>
                <td>
                    <input type='submit' value='Aceptar' />
                </td>
            </tr>
        </table>
    </form>
    
       </body>
</html>