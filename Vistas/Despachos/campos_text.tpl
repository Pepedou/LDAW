

<table>            
    <tr>
        <td>
            <p>Nombre del despacho</p>
        </td>
        <td>
            <input id = "nombre" type='text' name='nombre' value = "{$desp_nombre}" readonly/>    

        </td>
    </tr>
    <tr>
        <td>
            <p>Dirección del despacho:</p>
        </td>
        <td>
            <label for="calle">Calle</label>
            <input id = "calle" type='text' name='calle' value = "{$desp_calle}" readonly/>    
            </p>                     
        </td>
        <td>
            <label for="no_exterior">No. Exterior</label>
            <input type='text' name='no_exterior' value = "{$desp_ext}" readonly/>                         
        </td>
        <td>
            <label for="no_interior">No.Interior</label>
            <input type='text' name='no_interior' value = "{$desp_int}" readonly/>                         
        </td>
    <br>
    <td>
        <label for="colonia">Colonia</label>
        <input type='text' name='colonia' value = "{$desp_col}" readonly/>    
    </td>

    <td>
        <label for="ciudad">Cd</label>
        <input type='text' name='ciudad' value = "{$desp_cd}" readonly/>    
    </td>   

    <td>
        <label for="cp">cp</label>
        <input type='text' name='cp'value = "{$desp_cp}" readonly/>    
    </td>
    <td>

        <input type='hidden' id="op"  name='op' value = "Despacho" />
    </td>
</tr>
<tr>
    <td>
        <button onclick="eliminar();">{$accion}</button>  
    </td
</tr>
</table>

