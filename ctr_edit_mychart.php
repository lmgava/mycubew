<?

function __autoload($class){
	require_once("../classes/".$class.".class.php");
}


//$cron = new cron;
//$log = new log;
$mychart = new mychart;


$valida = $_POST['hi_valida']; //variavel que define a ação

print_r($_POST);


$dados[id_relatorio]         = $_POST["id_relatorio"];
$dados[query]	             = addslashes($_POST["form_query"]);
$dados[series]	 	         = $_POST["series"];
$dados[fonte] 	             = $_POST["fonte"];
$dados[titulo]		         = $_POST["titulo"];
$dados[relatorio]	         = $_POST["relatorio"];
$dados[responsavel]	         = $_POST["responsavel"];
$dados[tipo]	 	         = $_POST["tipo"];
$dados[eixox]	 	         = $_POST["eixox"];
$dados[rotulo_campo]	 	 = $_POST["rotulo_campo"];
$dados[rotulo_valor]	 	 = $_POST["rotulo_valor"];

if(empty($_POST["ativo"]))
		{ $dados[ativo]='0';}
	else{$dados[ativo]='1';}
	


if($valida=='incluir'){

$mychart->incluirChart($dados);
header('Location: ../interfaces/int_adm_mychart.php');

}

if($valida=='editar'){

$mychart->editarChart($dados);
header('Location: ../interfaces/int_adm_mychart.php');

}

if($valida=='excluir'){

$mychart->excluirChart($_POST["id_relatorio"]);
header('Location: ../interfaces/int_adm_mychart.php');

}



?>
