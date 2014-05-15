

    <table >
        <tr>       
            <td >
                <label for="nombre">Nombre</label>
                <input id = "nombre" type='text' name='nombre' value = "{$doc_nombre}" />  
            </td>



        <label for="documento"> Adjuntar Archivo: </label>
        <input type="hidden" name="max_file_size" value="1024000">
        <input type="file"  size="44" name ="documento" id="documento"/>        
        </tr>

        <td >
            <label for="expedientes">Expediente</label>
            <select id="expedientes" name ="id_Expediente">
            </select>
        </td>
        </tr> <input type ='hidden' id="op" name='op' value='Documento' />
        <td>
            <input type='submit' value='Aceptar' />
        </td>
        </tr>
    </table>