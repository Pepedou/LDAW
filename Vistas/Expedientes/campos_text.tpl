<table 
    <tr>        
        <td>
            <label for="nombre">Nombre Expediente</label>
            <input id = "nombre" type='text' name='nombre' value = "{$exp_nombre}" readonly />    
        </td>
    </tr>

    <td >
        <label for="casos">Caso</label>
        <input id = "nombre" type='text' name='nombre' value = "{$exp_caso}" readonly />    
    </td>
</tr> <input type ='hidden' id="op" name='op' value='Expediente' />
<td>
    <button onclick="eliminar();">{$accion}</button>  
</td>
</tr>
</table>
