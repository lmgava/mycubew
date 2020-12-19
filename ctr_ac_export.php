<?php

	function myAutoload($class) 
 {
 require_once("../classes/".$class.".class.php");
 }

 spl_autoload_register('myAutoload');

header('Content-type: text/html; charset=utf-8');

//$cron = new cron;
//$log = new log;
$ac_export = new ac_export;

print_r($_POST);

$valida = $_POST['hi_valida']; //variavel que define a ação


$id_report = $_POST["id_report"];
$query	     = addslashes($_POST["form_query"]);
$campos	 	 = $_POST["campos"];
$fonte 	     = $_POST["fonte"];
$variaveis 	 = $_POST["variaveis"];
@$titulo		 = $_POST["titulo"];
$relatorio	 = $_POST["relatorio"];
if(empty($titulo)){ $titulo = $relatorio; }

$responsavel	 = $_POST["responsavel"];

if(empty($_POST["ativo"]))
		{ $ativo ='0';}
	else{$ativo='1';}
	
if($valida=='incluir'){

$ac_export->incluirRel($query,$campos,$fonte,$titulo,$ativo,$relatorio,$responsavel,$variaveis);

header('Location: ../new/int_adm_myreport.php');

}

if($valida=='editar'){

$ac_export->updateRel($id_report,$query,$campos,$fonte,$titulo,$ativo,$relatorio,$responsavel,$variaveis);

header('Location: ../new/int_adm_myreport.php?act=7');

}

if($valida=='excluir'){
$ac_export->excluir($_POST["delId"]);
header('Location: ../new/int_adm_myreport.php?act=6');

}



?>
