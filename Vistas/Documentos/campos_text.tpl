<table 
    <tr>  

        <td >
            <label for="nombre">Nombre</label>
            <input id = "nombre" type='text' name='nombre' value = "{$doc_nombre}" readonly/>  
        </td>
    <form method="post" action="" enctype="multipart/form-data">
        Adjuntar Archivo: 
        <input type="file" name ="documento" >
    </form> 
</tr>

<td >
    <label for="expedientes">Expediente</label>
    <input id = "expedientes" type='text' name='expedientes' value = "{$doc_exp}" readonly />    
</td>

<td >
    <label for="tipos">Tipo</label>
    <input id = "tipos" type='text' name='tipos' value = "{$doc_tipo}" readonly />    
</td>
</tr> <input type ='hidden' id="op" name='op' value='Documento' />
<td>
        <button onclick="eliminar();">{$accion}</button>  
    </td>
</tr>
</table>