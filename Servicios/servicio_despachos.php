<?php
include_once '../Clases/Despacho.php';
$desp = new Despacho();
Debug::getInstance()->alert("asd");
$desp->atributos["nombre"] = "Garcia y garcia";

$json = $desp->service_selectIndividual();
echo $json;
?>
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

