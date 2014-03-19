<?php

include('../../Smarty/libs/Smarty.class.php');

// create object
$smarty = new Smarty;

$smarty->template_dir = '/home/ldaw-1018566/html_container/content/Proyecto/Smarty/demo/templates/';
$smarty->compile_dir = '/home/ldaw-1018566/html_container/content/Proyecto/Smarty/demo/templates_c/';
// assign some content. This would typically come from
// a database or other source, but we'll use static
// values for the purpose of this example.
$smarty->assign('name', 'george smith');
$smarty->assign('address', '45th & Harris');

// display it
//$smarty->testInstall();
$smarty->display('index.tpl');
?>