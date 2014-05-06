

<table>            
    <tr>

        <td><label for="casos">Nombre  </label>
            <input id = "nombre" type='text' name='nombre' value = "{$tarea_nombre}" />    
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
    <label for="calendario">Fecha de Vencimiento  </label>
    {html_select_date prefix="StartDate" time=$time end_year="+2"}

</select>
</tr> <input type ='hidden' id="op" name='op' value='Tarea' />
<tr>
    <td><label> Comentarios</label>
        <textarea name="descripcion" value = "{$tarea_descrip}" cols="30" rows="5" ></textarea>
        
    </td>
</tr>
<tr>
<br>
<td>
    <input type='submit' value='Aceptar' />
</td>
</tr>
</tr>
</table>

