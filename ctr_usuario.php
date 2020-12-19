<?php


	function myAutoload($class) 
 {
 require_once("../classes/".$class.".class.php");
 }

 spl_autoload_register('myAutoload');
 
 print_r($_POST);
 


$class_login = new login;
$class_usuario = new usuario;
$class_perfil = new perfil;

$class_login->validarSessao();

$acao = $_POST['hi_valida'];

//captura os dados e insere no array dados

$dados["user_name"]    = $_POST['user_name'];
$dados["user_login"]   = $_POST['user_login'];
$dados["id_perfil"]    = $_POST['user_perfil'];
$dados["user_email"]   = $_POST['user_email'];
$dados["user_mobile"]  = $_POST['user_mobile'];
$dados["user_active"]  = $_POST['user_active'];
$dados["hi_user_id"]   = $_POST['hi_user_id'];

$usuario = $_POST['usuario'];
$code  = $_POST['code'];
$senha_nova = $_POST['password'];



switch($acao){

	case "atualizar_senha_usuario":{		
	//	$usuario = $_SESSION['usuario'];
	//	$senha_antiga = $_POST['senha_antiga'];
	//	$senha_nova = $_POST['senha_nova'];
				
	
			$class_usuario->alterarSenha($usuario,$code,$senha_nova);
			//$class_usuario->alterarDataAlteracao($usuario);
			@session_destroy();
			echo "<script language='javascript'>parent.window.location.href='http://localhost/mycubew/new/index.php' </script>";

	}
	break;

	case "incluir":{

		
		$class_usuario->incluirUsuario($dados);            
		header('Location: ../new/int_adm_user.php?act=11');
	}
	break;


	case "excluir":{
		$id_usuario = $_POST['hi_user_id'];
		
		$class_usuario->excluirUsuario($id_usuario);
		header('Location: ../new/int_adm_user.php?act=13');
	}
	break;


	case "alterar":{


		$class_usuario->alterarUsuario($dados);
		header('Location: ../new/int_adm_user.php?act=12');
	}
	break;
	
	
	case "reset":{
		$id_usuario = $_POST['hi_user_id'];
		
		$class_usuario->resetarSenha($id_usuario);
		header('Location: ../new/int_adm_user.php?act=14');
	}
	break;
	
    
    	case "lock":{
if(isset($_POST["user_lock"])){ $value = 0;}else {$value=1;}

		$class_usuario->lockUser($_POST["hi_user_id"],$value);
		header('Location: ../new/int_adm_user.php?act=12');
	}
	break;
 

}

?>