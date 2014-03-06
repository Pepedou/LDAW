<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        include './Despacho.php';

        function proceso(EntidadBD $instancia) {
            $instancia->procesarForma();
        }

        $miDespacho = new Despacho();
        proceso($miDespacho);
        $debug = Debug::getInstance();
        $debug->alert($miDespacho->nombre . " " . $miDespacho->direccion);
        ?>
    </body>
</html>
