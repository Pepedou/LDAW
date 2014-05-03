

<table>            
    <tr>
        <td>
            <p>Nombre del Caso</p>
        </td>
        <td>
            <input id = "nombre" type='text' name='nombre' value = "{$caso_nombre}" />    
        </td>

        <td >
            <label for="despachos">Despacho</label>
            <select id="despachos" name ="id_Despacho">
            </select>
        </td>
        
        
        <td>
            <label for="clientes">Cliente</label>
            <select id="clientes" name ="id_Cliente">
            </select>
        </td>

        <td>
            <select id ="status" name="status">
                <option value="1">Activo</option> 
                <option value="0" selected>Inactivo</option>
            </select>
        </td>
    </tr>
    <input type ='hidden' id="op" name='op' value='Caso' />
    <td>
        <input type='submit' value='Aceptar' />
    </td>
</tr>
</table>

