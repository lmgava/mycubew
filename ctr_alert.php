<?php

function __autoload($class){
	require_once("../classes/".$class.".class.php");
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
        
$alert =  new alert;


        
$valida = $_POST['hi_valida'];
$dados[id_alert]   = $_POST['id_alert'];


if($valida=='excluir'){
    
     $alert->delAlert($dados[id_alert]);    
      redirect('../interfaces/int_alert.php');  
    
}

?>