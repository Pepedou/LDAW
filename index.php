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
        include './Abogado.php';

        $abogado = new Abogado();
        $abogado->_construct(estef, 123);
      
        
        $despacho = new Despacho();
        $despacho->almacenarEnBD();
        ?>
    </body>
</html>
