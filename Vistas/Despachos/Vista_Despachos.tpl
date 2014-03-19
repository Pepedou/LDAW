
<!--{include file="/home/ldaw-1018566/html_container/content/Proyecto/Vistas/Despachos/Funciones_Ajax.tpl"}!-->
<body onload="llenaEstados();">
    <h1>Altas</h1>    
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
                    <p>Dirección del despacho</p>
                </td>
                <td>
                    <input type='text' name='calle' />
                </td>
                <td>
                    <input type='text' name='colonia' />
                </td>
                <td >
                    <select id="estados">
                    </select>
                </td>
                <td>
                    <input type='text' name='ciudad' />
                </td>   
                <td id = municipios>

                </td>
                <td>
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