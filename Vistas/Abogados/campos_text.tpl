

<table>            
    <tr>
        <td>
            <p>Nombre del Abogado</p>
        </td>
        <td>
            <input id = "nombre" type='text' name='nombre' value = "{$abog_nombre}" readonly/>    

        </td>
    </tr>
    <tr>
          
        <td>
            <label for="apellidoP">Apellido Paterno</label>
            <input id = "apellidoP" type='text' name='apellidoP' value = "{$abog_apep}" readonly/>    
            </p>                     
        </td>
        <td>
            <label for="apellidoM">Apellido Materno</label>
            <input id = "apellidoM" type='text' name='apellidoM' value = "{$abog_apem}" readonly/>                         
        </td>
        <td>
            <label for="telefono">No.Interior</label>
            <input type='text' name='telefono' value = "{$abog_tel}" readonly/>                         
        </td>
    <br>
    <td>
        <label for="email">Email</label>
        <input type='text' name='email' value = "{$abog_email}" readonly/>    
    </td>

    <td>
        <label for="Rol">Rol</label>
        <input type='text' name='id_Rol' value = "{$abog_rol}" readonly/>    
    </td>   

    <td>
        <label for="Despacho">Despacho</label>
        <input type='text' name='id_Despacho'value = "{$abog_desp}" readonly/>    
    </td>
</tr>
<tr>  <input type ='hidden' id="op" name='op' value='Abogado' />
    <td>
        <button onclick="eliminar();">{$accion}</button>  
    </td>
</tr>
</table>

