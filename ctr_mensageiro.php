<?

//header("Content-type: text/html; charset=iso-8859-1");	// Header

function __autoload($class){
	require_once("../classes/".$class.".class.php");
}


function cod($string) {
        return mb_detect_encoding($string.'x', 'UTF-8, ISO-8859-1');
    }
    


//$var = utf8_decode($_POST['var']);	//Transformando caracteres

$dados[msg]      = $_POST["msg"];
$dados[r_user]   = $_POST["r_user"];
$dados[d_user]   = $_POST["d_user"];
$dados[id_reply] = $_POST["id_reply"];

$msg = new msg;

$valida = $_POST['hi_valida'];

echo cod($dados[msg]);

print_r($dados);


if($valida=='newmsg'){

    $msg->newMsg($dados);    
    header('Location: ../interfaces/int_mensageiro.php');

}


if($valida=='excluir'){

    $msg->delMsg($_POST["id_mensagem"]);
        
    header('Location: ../interfaces/int_mensageiro.php');

}



?>