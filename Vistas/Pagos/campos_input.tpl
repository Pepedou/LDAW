

<table>            
    <tr>
        <td >
            <label for="cantidad">Monto  $</label>
            <input id = "cantidad" type='number' name='cantidad' value = "{$pago_cant}" /> 
        </td>

        <td >
            <label for="clientes">Cliente</label>
            <select id="clientes" name ="id_Cliente">
            </select>
        </td>

    </tr> <input type ='hidden' id="op" name='op' value='Pago' />
    <td>
       <input type="submit" value="Aceptar">
    </td>
</tr>
</table>

