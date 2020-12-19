<?php

function __autoload($class){
	require_once("../classes/".$class.".class.php");
}


$cron = new cron;
$log = new log;

$result_cron = $cron->exec_cron($cron->verifica_id());


while($line = mysql_fetch_array($result_cron)){
   $cron->exec_rel($line["ID_CRON"],$line["ID_REL"],$line["EXT"]); 
   
   $log->logEmail('System','ctr_exec_cron.php');
   
}

?>