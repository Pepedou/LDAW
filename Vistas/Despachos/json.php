<?php
    include('../../Clases/Despacho.php');
    $desp = new Despacho();
    $desp->atributos["nombre"] = "Garcia y garcia";
    $json = $desp->service_selectIndividual();    
?>
