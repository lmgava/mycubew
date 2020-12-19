<?php

function myAutoload($class) 
 {
 require_once("../classes/".$class.".class.php");
 }

 spl_autoload_register('myAutoload');
 
 
 
$class_menu = new menu;
//$class_login = new login;

//$class_login->validarSessao();

print $acao = $_POST['hi_valida'];

print_r($_POST);

switch($acao){

	case "incluir":{		
		$hierarquia_menu = $_POST['hierarquia_menu'];
		$nome_menu = $_POST['nome_menu'];
		$link_menu = $_POST['link_menu'];
		$id_imagem = $_POST['optionsRadios'];		
		
		$class_menu->incluirMenu($hierarquia_menu,$nome_menu,$link_menu,$id_imagem);
	//	header('Location: ../new/int_adm_menu.php');
	}
	break;

	case "excluir":{	
		$id_menu = $_POST['hi_menu'];
		
		$class_menu->excluirMenu($id_menu);
		//header('Location: ../new/int_adm_menu.php');
	}
	break;

	case "editar":{
		$id_menu = $_POST['id'];
		$hierarquia_menu = $_POST['menu_type'];
		$nome_menu = $_POST['nome'];
		$link_menu = $_POST['tag_link'];
		$id_imagem = $_POST['tagicon'];
		
		$class_menu->alterarMenu($id_menu,$hierarquia_menu,$nome_menu,$link_menu,$id_imagem);
		header('Location: ../new/int_adm_menu.php');
	}
	break;
}

?>
