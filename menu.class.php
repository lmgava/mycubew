<?php
class menu{

	
	function carregaMenu($id_perfil){
	
		$mysql = new mysql();
		$class_menu = new menu;
		
		$query = "
						select   
				A.ID,
				RC_MENU,
				LINK,
				NOME,
				MENU_TAG,
				ICON,
				(SELECT COUNT(ID) AS TOTAL FROM fx_menu WHERE RC_MENU = A.ID) AS SUBPAGES
			from
				fx_menu  A
			
			inner join rc_perfil_menu
			on A.ID = rc_perfil_menu.ID_MENU
			
				
			where
				RC_MENU = 0 and
				ID_PERFIL = '$id_perfil'			
			order by 
				NOME
		;";
		
		$result_categoria = $mysql->sql($query);

		///<div style=\"overflow-y: scroll; overflow-x: hidden; height: 500px;\">
		//</div>
	
	$tag ="";
	
		
				while($line_categoria = mysqli_fetch_array($result_categoria)) {
					
				$menu_tag = "#".$line_categoria["MENU_TAG"];
				
						if($line_categoria["SUBPAGES"]>0){ 				
					
						$tag .= '			
							<li>
                                <a href="'.$menu_tag.'" data-toggle="collapse">
                                    <i class="'.$line_categoria["ICON"].'"></i>
                                    <span>'.$line_categoria["NOME"].' </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="'.$line_categoria["MENU_TAG"].'">
                                    <ul class="nav-second-level">';
									
								
									
						$tag .=	$class_menu->carregaSubMenu($line_categoria['ID'],$id_perfil);
			
										
										
									
				$tag .= "</ul>
					</li>";
				
				
				
								
									}else{
										
										$tag.='<li>
                                <a href="'.$line_categoria["LINK"].'">
                                    <i class="mdi mdi-forum-outline"></i>
                                    <span>'.$line_categoria["NOME"].' </span>
                                </a>
                            </li>';
								}


}									
				return ($tag);
				
				
				
	}
	
	
	function carregaSubMenu($id_menu,$id_perfil){
		
		$mysql = new mysql();
		$class_menu = new menu;
	
		$query = "
			select
				fx_menu.ID,
				RC_MENU,
				LINK,
				NOME,
				fx_menu_imagem.CLASS
			from
				fx_menu
				
			inner join rc_perfil_menu
			on fx_menu.ID = rc_perfil_menu.ID_MENU
			
			left join fx_menu_imagem
			on fx_menu.ID_MENU_IMAGEM = fx_menu_imagem.ID
			
			where
				RC_MENU = $id_menu and
				ID_PERFIL = $id_perfil
			order by 
				NOME
		;";
		$result_submenu = $mysql->sql($query);
		$tag = "";
		while($line_submenu = mysqli_fetch_array($result_submenu)) {
	
			
			if(!empty($line_submenu['LINK'])){			
				$tag .= "<li><a href=\"".$line_submenu['LINK']."\">".$line_submenu['NOME']."</a></li>";		
			}	
		}

 return($tag);
		
	}
	
	

	function listaMenu(){
		
		$mysql = new mysql();
		
		$query = "
			select
				fx_menu.ID,
				RC_MENU,
				LINK,
				NOME,
				fx_menu_imagem.CLASS
			from
				fx_menu
				
			left join fx_menu_imagem
			on fx_menu.ID_MENU_IMAGEM = fx_menu_imagem.ID	
				
			order by 
				NOME
		;";
		$result = $mysql->sql($query);
		
		return($result);
	}
	
	
	function listaImagemMenu(){
		
		$mysql = new mysql();
		
		$query = "
			select
				ID,
				CLASS,
				CATEGORIA
			from
				fx_menu_imagem
			where
				ATIVO = 1	
				
			order by 
				CATEGORIA
		;";
		$result = $mysql->sql($query);
		
		return($result);
	}
	
    function listPersonMenu($user){
   	     
         $mysql = new mysql();   
         
        $query = "SELECT `fx_person_menu`.`ID`,
                    `fx_person_menu`.`USER_LOGIN`,
                    `fx_person_menu`.`NAME`,
                    `fx_person_menu`.`LINK`,
                    `fx_person_menu`.`NEW_WIN`,
                    N_MENU,ORDER_MENU
                    
                FROM `fx_person_menu`
         WHERE
                USER_LOGIN = '$user'
                order by N_MENU, ORDER_MENU";
         
         $result = $mysql->sql($query);

return($result);

        
    }
	
	function listaCategoriaMenu($id){
	
    
		$mysql = new mysql();
		
		$query = "
				select
				ID,
				NOME,
				ICON
			from
				fx_menu
				
					where
				RC_MENU = 0
                AND
                ID like '$id'
			order by 
				ID
		;";
		$result = $mysql->sql($query);
		
		return($result);
	}	
	
        function getCategoriaMenu($id){
        
             
                  
       $mysql = new mysql;
        
      $query = "SELECT
ID,
NOME
FROM
fx_menu
WHERE
RC_MENU = 0;";
        
        $result = $mysql->sql($query);
    
    $tag ="";
    
    	while($line = mysqli_fetch_array($result)){
    	   
           if($line["ID"]==$id){ $active = "selected"; } else { $active=""; }
           
           $tag.= '<option '.$active.' value="'.$line["ID"].'">'.$line["NOME"].'</option>';
           
           
                    
    	}
        
        return ($tag);
    	   

        
    }
	
	function listaCategoriaMenuRelaciona($id_perfil){
	
		$mysql = new mysql();
		
		$query = "
			select
				menu.ID,
				menu.NOME,
				menu_rel.ID_MENU
			from
			(
				select 
					ID,
					NOME
				from
					fx_menu
				where
					RC_MENU =0
			) menu

			left join
			(
				select
					ID_MENU
				from
					rc_perfil_menu
				where 
					rc_perfil_menu.ID_PERFIL = $id_perfil
			) menu_rel
			
			on menu.ID = menu_rel.ID_MENU
			
			group by ID
			order by ID
		;";
		$result = $mysql->sql($query);
		
		return($result);
	}
	
	function listaRelacionamentoMenu($id_menu){
	
		$mysql = new mysql();
		
		$query = "
			select
				fx_menu.ID,
				RC_MENU,
				NOME,
				LINK,
				fx_menu_imagem.CLASS
			from
				fx_menu
				
			left join fx_menu_imagem
			on fx_menu.ID_MENU_IMAGEM = fx_menu_imagem.ID
			
			where
				RC_MENU = '$id_menu'
			order by 
				RC_MENU DESC
		;";
		$result = $mysql->sql($query);
		
		return($result);
	}	
	
	function listaRelacionamentoMenuRelaciona($id_menu,$id_perfil){
	
		$mysql = new mysql();
		
		$query = "
			select
				menu.ID,
				menu.NOME,
				menu_rel.ID_MENU
			from
			(
				select 
					ID,
					NOME
				from
					fx_menu
				where
					RC_MENU = $id_menu
			) menu

			left join
			(
				select
					ID_MENU
				from
					rc_perfil_menu
				where 
					rc_perfil_menu.ID_PERFIL = $id_perfil
			) menu_rel
			
			on menu.ID = menu_rel.ID_MENU
			
			group by ID
			order by ID
		;";
		$result = $mysql->sql($query);
		
		return($result);
	}	
	
	
	function incluirMenu($hierarquia_menu,$nome_menu,$link_menu,$id_imagem){
	
		$mysql = new mysql();
		
		$query = "
			 insert into fx_menu
			(RC_MENU,NOME,LINK,ID_MENU_IMAGEM) values ('$hierarquia_menu','$nome_menu','$link_menu','$id_imagem')
		;";
		$result = $mysql->sql($query);
	}
    
	
    function incluirPersonMenu($title_name,$link,$n_menu,$order_menu, $new_win, $user){
	
		$mysql = new mysql();
		
		$query = "INSERT INTO `lmgava_my_sis`.`fx_person_menu`
                (`USER_LOGIN`,
                `NAME`,
                `LINK`,
                `NEW_WIN`,
                `N_MENU`,
                `ORDER_MENU`)
            VALUES
                ('$user',
                '$title_name',
                '$link',
                '$new_win',
                '$n_menu',
                '$order_menu');";

		$result = $mysql->sql($query);
	
    }
    
	
	function excluirMenu($id_menu){
	
		$mysql = new mysql();
		
		$query = "
			delete from fx_menu
			where
			ID = '$id_menu'
		;";
		$result = $mysql->sql($query);
	}

    function delPersonMenu($id_person_menu){
        	$mysql = new mysql();
        $query="DELETE FROM `fx_person_menu`
WHERE 
ID = '$id_person_menu';";
	$result = $mysql->sql($query);
        
        
    }

	function alterarMenu($id_menu,$hierarquia_menu,$nome_menu,$link_menu,$id_imagem){
	
		$mysql = new mysql();
		
		$query = "
			replace into fx_menu
			(ID,RC_MENU,NOME,LINK,ID_MENU_IMAGEM) values ('$id_menu','$hierarquia_menu','$nome_menu','$link_menu','$id_imagem')
		;";
		$result = $mysql->sql($query);
	}
	
	
	function getNome($id_menu){
	
		$mysql = new mysql();
		
		$query = "
			select
				NOME
			from 
				fx_menu
			where
				ID = $id_menu
		;";
		$result = $mysql->sql($query);
		
		$line = mysql_fetch_array($result);
		
		return($line['NOME']);	
	}
	
	
	function getLink($id_menu){
	
		$mysql = new mysql();
		
		$query = "
			select
				LINK
			from 
				fx_menu
			where
				ID = $id_menu
		;";
		$result = $mysql->sql($query);
		
		$line = mysql_fetch_array($result);
		
		return($line['LINK']);	
	}
	
	
	function getPai($id_menu){
	
		$mysql = new mysql();
		
		$query = "
			select
				RC_MENU
			from 
				fx_menu
			where
				ID = $id_menu
		;";
		$result = $mysql->sql($query);
		
		$line = mysql_fetch_array($result);
		
		return($line['RC_MENU']);	
	}
	
	function getIdImagem($id_menu){
		
		$mysql = new mysql();
		
		$query = "
			select
				ID_MENU_IMAGEM
			from 
				fx_menu
			where
				ID = $id_menu
		;";
		$result = $mysql->sql($query);
		
		$line = mysql_fetch_array($result);
		
		return($line['ID_MENU_IMAGEM']);	
	}
    
    
    
     function editMenuValues($id){
        
        
                  
       $mysql = new mysql;
        
      $query = " 	select
				ID,
				NOME,
				ICON,
                LINK,
                PAGE_TAG,
                RC_MENU
			from
				fx_menu
				
					where
				RC_MENU = 0
                AND
                ID = '$id'
			order by 
				ID";
        
        $result = $mysql->sql($query);
    
    $tag ="";
    
    	$line = mysqli_fetch_array($result);
    	   
           $tag.= ' data-menu_type="0"';
           $tag.= ' data-id="'.$line["ID"].'" ';
           $tag.= ' data-nome="'.$line["NOME"].'" ';
           $tag.= ' data-tagicon="'.$line["ICON"].'" ';
           

           
           
        return ($tag);
    
    }
    
    
        function editPersonMenuValues($id){
        
        
                  
       $mysql = new mysql;
        
      $query = " SELECT
ID, USER_LOGIN, NAME, LINK, NEW_WIN, N_MENU, ORDER_MENU
FRom
`fx_person_menu` 
where
ID = '$id';";
        
        $result = $mysql->sql($query);
    
    $tag ="";
    
    	$line = mysqli_fetch_array($result);
    	   
      
           $tag.= ' data-id="'.$line["ID"].'" ';
           $tag.= ' data-title_name="'.$line["NAME"].'" ';
           $tag.= ' data-link="'.$line["LINK"].'" ';
           $tag.= ' data-n_menu="'.$line["N_MENU"].'" ';
           if($line["NEW_WIN"]==1){
            $tag.= ' data-new_win="checked" ';
           }
           
           $tag.= ' data-order_menu="'.$line["ORDER_MENU"].'" ';
           
           

           
           
        return ($tag);
    
    }
    
    
      function editPagesValues($id){
        
        
                  
       $mysql = new mysql;
        
      $query = " 	select
				ID,
				NOME,
				ICON,
                LINK,
                PAGE_TAG,
                RC_MENU
			from
				fx_menu
				
					where
		
                ID = '$id'
			order by 
				ID";
        
        $result = $mysql->sql($query);
    
    $tag ="";
    
    	$line = mysqli_fetch_array($result);
    	   
           $tag.= ' data-menu_type="0"';
           $tag.= ' data-id="'.$line["ID"].'" ';
           $tag.= ' data-nome="'.$line["NOME"].'" ';
           $tag.= ' data-tag_link="'.$line["LINK"].'" ';
           $tag.= ' data-page_tag="'.$line["PAGE_TAG"].'" ';
           $tag.= ' data-rc_menu="'.$line["RC_MENU"].'" ';
             
           

           
           
        return ($tag);
    
    }
	
    function getOptions($id){
        
             
                  
       $mysql = new mysql;
        
      $query = "SELECT
ID,
NOME
FROM
fx_menu
WHERE
RC_MENU = 0;";
        
        $result = $mysql->sql($query);
    
    $tag ="";
    
    	while($line = mysqli_fetch_array($result)){
    	   
           if($line["ID"]==$id){ $active = "active"; } else { $active=""; }
           
           $tag.= '<li><a class="dropdown-item '.$active.'" href="?id_category='.$line["ID"].'">'.$line["NOME"].'</a></li>';

           
    	}
        
        return ($tag);
    	   

        
    }
	
}

?>