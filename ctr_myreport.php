<!DOCTYPE html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php

function myAutoload($class)
 {
 require_once("../classes/".$class.".class.php");
 }

 spl_autoload_register('myAutoload');



$id_rel = $_GET["ID_REL"];

$myreport = new myreport;
$myreport->execReport($id_rel);

//$log->logAcao($usuario,$_SERVER['REQUEST_URL'],'REL');

?>