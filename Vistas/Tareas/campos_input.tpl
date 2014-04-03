

<table>            
    <tr>
        <td>
            <p>Nombre Tarea</p>
        </td>
        <td>
            <input id = "nombre" type='text' name='nombre' value = "{$tarea_nombre}" />    
        </td>
        <td><label for="descripcion">Descripcion</label>
            <input id = "descripcion" type='text' name='descripcion' value = "{$tarea_descrip}" />    
        </td>
        <td >
            <label for="abogados">Abogado</label>
            <select id="abogados" name ="id_Abogado">
            </select>
        </td>

        <td >
            <label for="casos">Caso</label>
            <select id="casos" name ="id_Caso">
            </select>
        </td>

        </select>
    </tr> <input type ='hidden' id="op" name='op' value='Tarea' />
    <td>
        <input type='submit' value='Aceptar' />
    </td>
</tr>
</table>

