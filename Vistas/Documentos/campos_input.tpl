<table >
    <tr>       
        <td >
            <label for="nombre">Nombre</label>
          <input id = "nombre" type='text' name='nombre' value = "{$doc_nombre}" />  
        </td>


    <form method="post" action="" enctype="multipart/form-data">
        Adjuntar Archivo: 
        <input type="file" name ="documento" >
    </form> 
</tr>

<td >
    <label for="expedientes">Expediente</label>
    <select id="expedientes" name ="id_Expediente">
    </select>
</td>

<td >
    <label for="tipos">Indique el Tipos</label>
    <select id="tipos" name ="id_Tipo">
    </select>
</td>
</tr> <input type ='hidden' id="op" name='op' value='Documento' />
<td>
    <input type='submit' value='Aceptar' />
</td>
</tr>
</table>