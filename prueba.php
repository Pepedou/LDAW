<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
            include './Despacho.php';
            
            function proceso(EntidadBD $instancia){
                $instancia->generarFormaBorrado();
            }
            
            $miDespacho = new Despacho();
            proceso($miDespacho);
            
        ?>
    </body>
</html>
