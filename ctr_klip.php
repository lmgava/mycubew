<?php


	
	function myAutoload($class) 
 {
 require_once("../classes/".$class.".class.php");
 }

 spl_autoload_register('myAutoload');
 
 
 

//$cron = new cron;
//$log = new log;
$mychartnew = new mychartnew;

$valida = $_POST['hi_valida']; //variavel que define a ação

print_r($_POST);



@$type                       =  $_POST["type"];
@$query                      = addslashes($_POST["form_query"]);
@$graf_desc   	             = $_POST["graf_desc"];
@$code	                     = $_POST["code"];
@$variables                  =  $_POST["variables"];
@$chart_source	             = $_POST["graf_source"];
@$chart_title		         = $_POST["graf_title"];
@$chart_id                   = $_POST["chart_id"];
@$chart_size_width           = $_POST["chart_size_width"];
@$chart_size_height           = $_POST["chart_size_height"];

if($valida=='include_dash'){
    
    $dash_name = $_POST["name_dash"];
    $dash_desc = $_POST["desc_dash"];
    $owner_only = $_POST["owner_only"];
    $login_owner = $_POST["owner_login"];
        
   $mychartnew->insertDash($dash_name,$dash_desc,$login_owner,$owner_only);
    header('Location: ../new/int_adm_dash.php?act=15');
}

if($valida=='incluir'){
$code = addslashes($code);

$mychartnew->insertKlip($type,$code,$variables,$query,$graf_desc,$chart_title,$chart_source,$chart_size_width,$chart_size_height);
header('Location: ../new/int_adm_klip.php?act=15');
}

if($valida=='editar'){

$mychartnew->updateKlip($chart_id,$type,$code,$variables,$query,$graf_desc,$chart_title,$chart_source,$chart_size_width,$chart_size_height);
//$mychart->editarChart($dados);
header('Location: ../new/int_adm_klip.php?act=16');
}

if($valida=='excluir'){

$mychartnew->delKlip($_POST["delId"]);
header('Location: ../new/int_adm_klip.php?act=17');

}



?>
