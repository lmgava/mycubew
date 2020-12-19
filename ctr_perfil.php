<?php

function myAutoload($class) 
 {
 require_once("../classes/".$class.".class.php");
 }

 spl_autoload_register('myAutoload');
 
 

print_r($_POST);


$class_perfil = new perfil;


@$valida = $_POST['hi_valida'];
@$qtd_categoria = $_POST['hi_num_categoria'];
@$qtd_relacionamento = $_POST['hi_num_relacionamento'];
@$qtd_relacionamento_sub = $_POST['hi_num_relacionamento_sub'];
@$id_perfil = $_POST['hi_perfil'];

@$nome_perfil = $_POST['nome_perfil'];
@$area_perfil = $_POST['area_perfil'];


if($valida == "incluir"){	
	
	$class_perfil->incluirPerfil($nome_perfil,$area_perfil);
	header('Location: ../new/int_adm_perfil.php?act=11');
}


if($valida == "excluir"){

	$class_perfil->excluirPerfil($id_perfil);
	header('Location: ../new/int_adm_perfil.php?act=13');
}


if($valida == "alterar"){

	 $class_perfil->alterarPerfil($id_perfil,$nome_perfil,$area_perfil);
	header('Location: ../new/int_adm_perfil.php?act=11');
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