<?php

function myAutoload($class) 
 {
 require_once("../classes/".$class.".class.php");
 }

 spl_autoload_register('myAutoload');
 
 

print_r($_POST);



$menu = new menu;


@$valida = $_POST['hi_valida'];
@$n_menu = $_POST['n_menu'];
@$title_name = $_POST['title_name'];
@$link = $_POST['link'];
$order_menu = $_POST['order_menu'];
$new_win = $_POST['new_win'];
$user = $_POST["user"];


if($valida == "incluir"){	
	//ID, USER_LOGIN, NAME, LINK, NEW_WIN, N_MENU, ORDER_MENU
    
	$menu->incluirPersonMenu($title_name,$link,$n_menu,$order_menu, $new_win, $user);
	header('Location: ../new/int_adm_menu_person.php?act=11');
}


if($valida == "excluir"){

	$menu->delPersonMenu($_POST["id_person_menu"]);
	header('Location: ../new/int_adm_menu_person.php?act=13');
}


if($valida == "alterar"){

	// $class_perfil->alterarPerfil($id_perfil,$nome_perfil,$area_perfil);
//	header('Location: ../new/int_adm_perfil.php?act=11');
}


if($valida == "alterar_multiplo"){
    

    

	$class_perfil->ExcluirAcessoPerfil($id_perfil);
	
	for($i = 0 ; $i <= $qtd_categoria ; $i++){
		
        @$id_menu_categoria = $_POST['id_categoria_'.$i];
		
        
		if(!empty($id_menu_categoria)){
			$class_perfil->IncluirAcessoPerfil($id_perfil,$id_menu_categoria);
		}	

		for($j = 0 ; $j <= $qtd_relacionamento ; $j++){
		  
          
	   @$id_menu_relacionamento = $_POST['id_relacionamento-'.$i.'-'.$j];
			
			if(!empty($id_menu_relacionamento)){
             
				$class_perfil->IncluirAcessoPerfil($id_perfil,$id_menu_relacionamento);	
			}
		}
	}
    header('Location: ../new/int_adm_perfil.php?act=12');
}
?>