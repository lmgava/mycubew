<?php

function __autoload($class){
	require_once("../classes/".$class.".class.php");
}

$class_login = new login;

$class_login->validarSessao();

//busca as variaveis do posto 

$valida = $_POST['hi_valida']; //variavel que define a ação

$nome_agendamento = $_POST["nome_agendamento"];
$hora_agendamento = $_POST["hora_agendamento"];
$dia_semana		  = $_POST["dia_semana"];
$dia_mes 		  = $_POST["dia_mes"];
$ativo 			  = $_POST["ativo"];
    if(empty($ativo)){ $ativo='0';}    
$destinatario 	  = $_POST["destinatario"];
$assunto 		  = $_POST["assunto"];
$descricao 		  = $_POST["descricao"];
$ext 			  = $_POST["ext"];
$nome_arquivo  	  = $_POST["nome_arquivo"];
$id_relatorio 	  = $_POST["id_relatorio"];
$id_cron          = $_POST["id_cron"];


$class_cron = new cron;

if($valida == 'incluir'){ 

    
	$class_cron->incluirCron($hora_agendamento,$nome_agendamento,$id_relatorio,$dia_mes,$dia_semana,$dia_dia,$ativo,$destinatario,$assunto,$descricao,$arquivo,$ext,$nome_arquivo);
	header('Location: ../interfaces/int_adm_cron.php');
}

if($valida == 'excluir'){
    
	$class_cron->excluirCron($id_cron);
	header('Location: ../interfaces/int_adm_cron.php');
}

if($valida == 'editar'){
	
    $class_cron->alterarCron($id_cron,$hora_agendamento,$nome_agendamento,$id_relatorio,$dia_mes,$dia_semana,$dia_dia,$ativo,$destinatario,$assunto,$descricao,$arquivo,$ext,$nome_arquivo);	
    header('Location: ../interfaces/int_adm_cron.php');
}

?>
