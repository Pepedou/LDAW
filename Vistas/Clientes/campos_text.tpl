
<p>Datos del Cliente </p>
<table>            
    <tr>        
        <td>
            <label for="nombre">Nombre Cliente</label>
            <input id = "nombre" type='text' name='nombre' value = "{$cliente_nombre}" readonly />    
        </td>
    </tr>
    <tr>

        <td>
            <label for="apellidoP">Apellido Paterno</label>
            <input id = "apellidoP" type='text' name='apellidoP' value = "{$cliente_apep}" readonly/>    
            </p>                     
        </td>
        <td>
            <label for="apellidoM">Apellido Materno</label>
            <input id = "apellidoM" type='text' name='apellidoM' value = "{$cliente_apem}" readonly />                         
        </td>
        <td>
            <label for="telefono">Tel&eacute;fono</label>
            <input type='text' name='telefono' value = "{$cliente_tel}" readonly />                         
        </td>
    <br>
    <td>
        <label for="email">Email</label>
        <input type='text' name='email' value = "{$cliente_email}" readonly/>    
    </td>
</tr>
</table>

<br>

<p>Dirección :</p>
<table>
    <tr>     
        <td>
            <label for="calle">Calle</label>
            <input id = "calle" type='text' name='calle' value = "{$cliente_calle}" readonly />    
            </p>                     
        </td>
        <td>
            <label for="no_exterior">No. Exterior</label>
            <input type='text' name='no_exterior' value = "{$cliente_ext}" readonly />                         
        </td>
        <td>
            <label for="no_interior">No.Interior</label>
            <input type='text' name='no_interior' value = "{$cliente_int}" readonly/>                         
        </td>
    </tr>
    <tr>
    <br>
    <td>
        <label for="colonia">Colonia</label>
        <input type='text' name='colonia' value = "{$cliente_col}" readonly />    
    </td>

    <td>
        <label for="ciudad">Cd</label>
        <input type='text' name='ciudad' value = "{$cliente_cd}" readonly/>    
    </td>   

    <td>
        <label for="cp">cp</label>
        <input type='text' name='cp'value = "{$cliente_cp}"readonly />    
    </td>
</tr> <input type ='hidden' id="op" name='op' value='Cliente' />

<tr>  
    <td>
        <button onclick="eliminar();">{$accion}</button>  
    </td

</table>

