<body onload="llenaDespachos(); llenaRoles(); llenaEstados();llenaEntidad('{$name}','{$tabla}','{$campo}');">
    
    <h1>Actualiza {$tabla}</h1>        

        <td >
            <label for="{$name}">{$nombre_titulo}</label>
            <select id="{$name}" name ="{$name}" selected="{$sel}" onchange='actualiza(this);'>
            </select>
        </td>