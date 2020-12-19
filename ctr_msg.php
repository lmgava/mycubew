<!DOCTYPE html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?


function __autoload($class){
	require_once("../classes/".$class.".class.php");
}


function cod($string) {
        return mb_detect_encoding($string.'x', 'UTF-8, ISO-8859-1');
    }


function redirect($url)
{
    if (!headers_sent())
    {    
        header('Location: '.$url);
        exit;
        }
    else
        {  
        echo '<script type="text/javascript">';
        echo 'window.location.href="'.$url.'";';
        echo '</script>';
        echo '<noscript>';
        echo '<meta http-equiv="refresh" content="0;url='.$url.'" />';
        echo '</noscript>'; exit;
    }
}
        



$dados[msg]      = ($_POST["msg"]);
//$dados[msg]    = utf8_decode($_POST["msg"]);
$dados[r_user]   = $_POST["r_user"];
$dados[d_user]   = $_POST["d_user"];
$dados[id_reply] = $_POST["id_reply"];

$msg = new msg;

$valida = $_POST['hi_valida'];



if($valida=='newmsg'){

    $msg->newMsg($dados); 
     
    redirect('../interfaces/int_mensageiro.php');  


}


if($valida=='excluir'){

    $msg->delMsg($_POST["id_mensagem"]);        
    redirect('../interfaces/int_mensageiro.php');

}



?>