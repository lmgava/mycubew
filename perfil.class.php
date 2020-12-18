<?php
class perfil{

    
    function listaEmpresa(){
        
        		$mysql = new mysql();
		
		$query = "
			SELECT
                ID_EMPRESA,
                EMPRESA
   FROM fx_empresa
                WHERE
                ATIVO  ='1'
		;";
		$result = $mysql->sql($query);
		
		return($result);
    }
    
	function listaPerfil(){
		
		$mysql = new mysql();
		
		$query = "
			select
				ID,
				NOME,
				AREA
			from
				fx_perfil
			order by 
				NOME desc
		;";
		$result = $mysql->sql($query);
		
		return($result);
	}
	
	
	function incluirPerfil($nome_perfil,$area_perfil){
		
		$mysql = new mysql();
		
	print	$query = "
			insert into fx_perfil
			(NOME,AREA) values ('$nome_perfil','$area_perfil')
		;";
		$result = $mysql->sql($query);
	}
	
	
	function excluirPerfil($id_perfil){
		
		$mysql = new mysql();
		
		$query = "
			delete from fx_perfil
			where ID = '$id_perfil'
		;";
		$result = $mysql->sql($query);
	}
	
	function alterarPerfil($id_perfil,$nome_perfil,$area_perfil){
		
		$mysql = new mysql();
		
		$query = "
			update lmgava_my_sis.fx_perfil
			set
				NOME = '$nome_perfil',
				AREA = '$area_perfil'
			where
				ID = '$id_perfil'
		;";
        
		$result = $mysql->sql($query);
	}
	
	function ExcluirAcessoPerfil($id_perfil){
		
		$mysql = new mysql();
		
		$query = "
			delete from
				rc_perfil_menu
			where
				ID_PERFIL = '$id_perfil'
		;";		
		$result = $mysql->sql($query);
	}
	
	function IncluirAcessoPerfil($id_perfil,$id_menu){
		
		$mysql = new mysql();
		
		 $query = "
			replace into rc_perfil_menu 
			values ('$id_perfil','$id_menu')
		;";		
		$result = $mysql->sql($query);
	}
	
	
	function getNome($id_perfil){
	
		$mysql = new mysql();
	
		$query = "
			select
			NOME
			from fx_perfil
			where
			ID = '$id_perfil'
		;";
		$result = $mysql->sql($query);
		$line = mysqli_fetch_array($result);
		
		return $line['NOME'];	
	}
	
	
	function getArea($id_perfil){
	
		$mysql = new mysql();
	
		$query = "
			select
			AREA
			from fx_perfil
			where
			ID = '$id_perfil'
		;";
		$result = $mysql->sql($query);
		$line = mysqli_fetch_array($result);
		
		return $line['AREA'];	
	}
    
    function editCheckValues($id){
        
        		$mysql = new mysql();
	
		$query = "
			select
		*
			from fx_perfil
			where
			ID = '$id'
		;";
		$result = $mysql->sql($query);
        
		$line = mysqli_fetch_array($result);
  
           $tag="";
           $tag.= ' data-id="'.$line["ID"].'" ';
           $tag.= ' data-area="'.$line["AREA"].'" ';
           $tag.= ' data-nome_perfil="'.$line["NOME"].'" ';

           
           return($tag);
        
        
    }
    
    
        function getOptions($id){
        
             
                  
       $mysql = new mysql;
        
      $query = "SELECT
ID,
NOME
FROM
fx_perfil
;";
        
        $result = $mysql->sql($query);
    
    $tag ="";
    
    	while($line = mysqli_fetch_array($result)){
    	   
           if($line["ID"]==$id){ $active = "active"; } else { $active=""; }
           
           $tag.= '<li><a class="dropdown-item '.$active.'" href="?id_perfil='.$line["ID"].'">'.$line["NOME"].'</a></li>';

           
    	}
        
        return ($tag);
    	   

        
    }
    
    
    
}
?>