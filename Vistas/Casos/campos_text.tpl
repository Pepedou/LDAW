

<table>            
    <tr>
        <td>
            <p>Nombre del Caso</p>
        </td>
        <td>
            <input id = "nombre" type='text' name='nombre' value = "{$caso_nombre}" readonly/>    
        </td>

        <td><label for="status">Status</label>
            <input id = "status" type='text' name='status' value = "{$caso_status}" readonly/>    
        </td>

        <td><label for="despacho">Despacho</label>
            <input id = "despacho" type='text' name='despacho' value = "{$caso_desp}" readonly/>    
        </td>
        <td><label for="cliente">Cliente</label>
           <input id = "cliente" type='text' name='cliente' value = "{$caso_cliente}" readonly/>  
        </td>
    </tr>
     <input type ='hidden' id="op" name='op' value='Caso' />
    <td>
        <button onclick="eliminar();">Borrar</button>  
    </td>
</tr>
</table>

