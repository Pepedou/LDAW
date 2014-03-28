
   
        <table>            
            <tr>
                <td>
                    <p>Nombre del despacho</p>
                </td>
                <td>
                    <input id="nombre" type='text' name='nombre' value = "{$desp_nombre}"/>
                   
                </td>
            </tr>
            <tr>
                <td>
                    <p>Dirección del despacho:</p>
                </td>
                <td>
                    <label for="calle">Calle</label>
                    <input type='text' name='calle' value = "{$desp_calle}" />                     
                </td>
                <td>
                    <label for="no_exterior">No. Exterior</label>
                    <input type='text' name='no_exterior' value = "{$desp_ext}"/>                     
                </td>
                 <td>
                    <label for="no_interior">No.Interior</label>
                    <input type='text' name='no_interior' value = "{$desp_int}"/>                     
                </td>
            <br>
                <td>
                    <label for="colonia">Colonia</label>
                    <input type='text' name='colonia' value = "{$desp_col}"/>
                </td>
                <td >
                    <label for="estados">Estado</label>
                    <select id="estados" name="id_Estado" selected ="{$select_edo}" onChange="llenaMunicipios(this.value)">
                    </select>
                </td>
                <td >
                    <label for="municipios">Municipio</label>
                    <select id="municipios" name ="id_Municipio" selected="{$select_mun}">
                    </select>
                </td>
                <td>
                    <label for="ciudad">Cd</label>
                    <input type='text' name='ciudad'value = "{$desp_cd}" />
                </td>   
                
                <td>
                    <label for="cp">cp</label>
                    <input type='text' name='cp' value = "{$desp_cp}" />
                </td>
            </tr>
            <tr>
                <td>
                    <input type='submit' value='Aceptar' />
                </td>
            </tr>
        </table>

    