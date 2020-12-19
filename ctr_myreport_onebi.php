<!DOCTYPE html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php

function __autoload($class){
	require_once("../classes/".$class.".class.php");
}

	
$id_rel = $_GET["ID_REL"];

$myreport = new myreport;
//$log      = new log;

$myreport->execReport($id_rel);

//$log->logAcao($usuario,$_SERVER['REQUEST_URL'],'REL');

?>