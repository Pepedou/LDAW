

<table>            
    <tr>
        <td>
            <p>Nombre del Abogado</p>
        </td>
        <td>
            <input id = "nombre" type='text' name='nombre' value = "{$abog_nombre}" />    
        </td>
    </tr>
    <tr>

        <td>
            <label for="apellidoP">Apellido Paterno</label>
            <input id = "apellidoP" type='text' name='apellidoP' value = "{$abog_apep}"/>    
            </p>                     
        </td>
        <td>
            <label for="apellidoM">Apellido Materno</label>
            <input id = "apellidoM" type='text' name='apellidoM' value = "{$abog_apem}" />                         
        </td>
        <td>
            <label for="telefono">Tel&eacute;fono</label>
            <input type='text' name='telefono' value = "{$abog_tel}" />                         
        </td>
    <br>
    <td>
        <label for="email">Email</label>
        <input type='text' name='email' value = "{$abog_email}" />    
    </td>

    <td >
        <label for="roles">Rol</label>
        <select id="roles" name="id_Rol" selected ="{$select_tol}" >
        </select>
    </td>
    <td >
        <label for="despachos">Despacho</label>
        <select id="despachos" name ="id_Despacho" selected="{$select_desp}">
        </select>
    </td>
    <input type ='hidden' id="op" name='op' value='Abogado' />
</tr>
<tr>
    <td>
        <input type='submit' value='Aceptar' />
    </td>

</table>

