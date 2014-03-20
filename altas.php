<?php
    include_once './Clases/Despacho.php';
    
    

    function html(EntidadBD $entidad) {
        if (!$entidad->procesarForma()) {
            
            $entidad->generarFormaInsercion($entidad::$smarty);
        }
    }

    $objeto = new Despacho();
    ?>
<?php html($objeto); ?>
