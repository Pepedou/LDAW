

<table>            
    <tr>
        <td>
            <p>Nombre del despacho</p>
        </td>
        <td>
            <input id = "nombre" type='text' name='nombre' value = "
                   {php}
                    if ($exito) echo $desp->atributos["nombre"]; else echo  $desp->atributos["nombre"];
                   {/php}
                   " readonly/>    

        </td>
    </tr>
    <tr>
        <td>
            <p>Dirección del despacho:</p>
        </td>
        <td>
            <label for="calle">Calle</label>
            <input id = "calle" type='text' name='calle' value = "
                   {php}
                    if ($exito2) echo $dir->atributos["calle"]; else echo "Calle";
                   {/php}
                   " readonly/>    
            </p>                     
        </td>
        <td>
            <label for="no_exterior">No. Exterior</label>
            <input type='text' name='no_exterior' value = "
                   {php}
                    if ($exito2) echo $dir->no_exterior; else echo "No.";
                   {/php}
                   " readonly/>                         
        </td>
        <td>
            <label for="no_interior">No.Interior</label>
            <input type='text' name='no_interior' value = "
                   {php}
                    if ($exito2) echo $dir->no_interior; else echo "No.";
                   {/php}
                   " readonly/>                         
        </td>
    <br>
    <td>
        <label for="colonia">Colonia</label>
        <input type='text' name='colonia' value = "
                   {php}
                    if ($exito2) echo $dir->colonia; else echo "Colonia";
                   {/php}
                   " readonly/>    
    </td>

    <td>
        <label for="ciudad">Cd</label>
        <input type='text' name='ciudad' value = "
                   {php}
                    if ($exito2) echo $dir->ciudad; else echo "Cd";
                   {/php}
                   " readonly/>    
    </td>   

    <td>
        <label for="cp">cp</label>
        <input type='text' name='cp'value = "
                   {php}
                    if ($exito2) echo $dir->cp; else echo "cp";
                   {/php}
                   " readonly/>    
    </td>
</tr>
<tr>
    <td>
        <input type='submit' value='Borrar' />
    </td>
</tr>
</table>

