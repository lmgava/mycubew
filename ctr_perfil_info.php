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


$user = new usuario;






$dados[nome_usuario]    = $_POST['nome_usuario'];
$dados[login_usuario]   = $_POST['login_usuario'];
$dados[email]           = $_POST['email_usuario'];
$dados[cel]             = $_POST['cel'];
$dados[niver]           = substr($_POST['niver'],6,4)."-".substr($_POST['niver'],3,2)."-".substr($_POST['niver'],0,2);
$dados[id_usuario]      = $_POST['id_usuario'];
$dados[img]             = $_POST['img'];
$dados[senha]           = $_POST['senha'];

$dados[senha] = $user->testeSenha($dados[senha],$dados[id_usuario]);

if(!empty($_FILES["arquivo"])){

$DIRETORIO_GRAVACAO = '../img_perfil/';

function transform($txt){
   $beta=array(
      a,a,a,a,a,e,e,e,e,i,i,i,i,o,o,o,o,o,u,u,u,u,c,A,A,A,A,A,E,E,E,E,I,I,I,I,O,O,O,O,O,U,U,U,U,C,"_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_"
   );
   $alfa=array(
      á,à,ã,â,ä,é,è,ê,ë,í,ì,î,ï,ó,ò,õ,ô,ö,ú,ù,û,ü,ç,Á,À,Ã,Â,Ä,É,È,Ê,Ë,Í,Ì,Î,Ï,Ó,Ò,Õ,Ô,Ö,Ú,Ù,Û,Ü,Ç,"\"","'","!","@","#","$","%","&","*","(",")","+","}","]","=","º","§","{","[","ª","?","/","°","<",">","\\","|",",",";",":","~","^","´","`"
   );
   $gama=str_replace($alfa,$beta,$txt);
   $omega=strtoupper($gama);
   $omega=strip_tags($omega);
   $omega=trim($omega);
   return($omega);
}

$arquivo = isset($_FILES["arquivo"]) ? $_FILES["arquivo"] : false;	


// Tamanho máximo do arquivo (em bytes)
$config["tamanho"] = 30000000;

if($arquivo){
	if($arquivo["size"] > $config["tamanho"])	{
		echo 'tamanho inviável';
	}	
    
	preg_match("/\.(gif|bmp|png|jpg|jpeg|ppt|txt|doc|docx|exe|zip|xls|xlsx|php|pdf){1}$/i", $arquivo["name"], $ext);	
	
    $extt = pathinfo($arquivo["name"], PATHINFO_EXTENSION);
    
        
    $imagem_nome = "img-".$id_usuario.".".$extt;
    
    
    $img_end = $DIRETORIO_GRAVACAO.$imagem_nome;
    
    if(file_exists($img_end)){    unlink($img_end); }
        
    $arquivo["tmp_name"];

    move_uploaded_file($arquivo["tmp_name"], $img_end);
    
    
$dados[img] = $imagem_nome;
    
}

}

$user->alterarPerfil($dados);

redirect('../interfaces/int_perfil_info.php?atualizado=1');

	
?>