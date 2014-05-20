
<p>Datos del Cliente </p>
<table>            
    <tr>        
        <td>
            <label for="nombre">Nombre Cliente</label>
            <input id = "nombre" type='text' name='nombre' value = "{$cliente_nombre}" />    
        </td>           
        <td>
            <label for="contrasena">Contraseña</label>
            <input id = "contrasena" type='password' name='contrasena' value = "{$cliente_contrasena}" />    
        </td>
        <td>
            <label for="contrasena_conf">Confirmación de Contraseña</label>
            <input id = "contrasena_conf" type='password' name='contrasena_conf' value = "{$cliente_contrasena2}" />    
        </td>
    </tr>
    <tr>

        <td>
            <label for="apellidoP">Apellido Paterno</label>
            <input id = "apellidoP" type='text' name='apellidoP' value = "{$cliente_apep}"/>    
            </p>                     
        </td>
        <td>
            <label for="apellidoM">Apellido Materno</label>
            <input id = "apellidoM" type='text' name='apellidoM' value = "{$cliente_apem}" />                         
        </td>
        <td>
            <label for="telefono">Tel&eacute;fono</label>
            <input type='text' name='telefono' value = "{$cliente_tel}" />                         
        </td>
    <br>
    <td>
        <label for="email">Email</label>
        <input type='text' name='email' value = "{$cliente_email}" />    
    </td>
</tr>
</table>

<br>

<p>Dirección :</p>
<table>
    <tr>     
        <td>
            <label for="calle">Calle</label>
            <input id = "calle" type='text' name='calle' value = "{$cliente_calle}" />    
            </p>                     
        </td>
        <td>
            <label for="no_exterior">No. Exterior</label>
            <input type='text' name='no_exterior' value = "{$cliente_ext}" />                         
        </td>
        <td>
            <label for="no_interior">No.Interior</label>
            <input type='text' name='no_interior' value = "{$cliente_int}" />                         
        </td>
    </tr>
    <tr>
    <br>
    <td>
        <label for="colonia">Colonia</label>
        <input type='text' name='colonia' value = "{$cliente_col}" />    
    </td>

    <td>
        <label for="ciudad">Cd</label>
        <input type='text' name='ciudad' value = "{$cliente_cd}" />    
    </td>   
    <td >
        <label for="estados">Estado</label>
        <select id="estados" name="id_Estado" selected ="{$sel_edo}" onChange="llenaMunicipios(this.value)">
        </select>
    </td>
    <td >
        <label for="municipios">Municipio</label>
        <select id="municipios" name ="id_Municipio" selected="{$sel_mun}">
        </select>
    </td>

    <td>
        <label for="cp">cp</label>
        <input type='text' name='cp'value = "{$cliente_cp}" />    
    </td>
</tr> <input type ='hidden' id="op" name='op' value='Cliente' />

<tr>
    <td>
        <button onclick="verificar();">Registrar</button>  
    </td>

</table>

