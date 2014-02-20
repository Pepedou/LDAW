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
        include './Abogado.php';
        include './Caso.php';
        include './Despacho.php';
      
        $caso = new Caso();
        $caso->id_despacho = 1;
        $caso->nombre= "Caso R versus el Gobierno";
        $caso->almacenarEnBD();
              
        $despacho = new Despacho();
        $despacho->almacenarEnBD();
        
        ?>
    </body>
</html>
