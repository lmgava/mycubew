<?php
error_reporting(E_ERROR | E_PARSE);

/**
 * usuario
 * 
 * @package 
 * @author Bruno Loiola
 * @copyright 2013
 * @version 1
 * @access public
 */
 
 
class usuario{

	
	
function alterarDataAlteracao($usuario){
	
		$mysql = new mysql();
	
		$query = "
		update fx_usuarios
			set
				DATA_ATUALIZACAO = sysdate()
		where
			LOGIN = '$usuario'		
		;";
	
		$result = $mysql->sql($query);
	}
	
function alterarSenha($usuario,$code,$senha_nova){
	
		$mysql = new mysql();		
	
	$query = "
		update fx_usuarios
			set
				SENHA = password('$senha_nova'),
                DATA_ATUALIZACAO = sysdate()
		where
			LOGIN = '$usuario'
            AND
           	RESET_CODE ='$code'
		;";	
		
		$result = $mysql->sql($query);
	}
	
	
	function validarSenha($usuario,$senha_antiga,$senha_nova){
	
		$mysql = new mysql();
		
		print $query = "select
				LOGIN
			from
				fx_usuarios
			where
				LOGIN = '$usuario' and
				SENHA = password('$senha_antiga');";		
        // and	SENHA <> password('$senha_nova')
        //pedaço desativa pro reduzir o trampo..
        
		$result = $mysql->sql($query);
		
		if(mysqli_num_rows($result) == 0){
			return(0);		
		} else {
			return(1);
		}	
	}
	
	function listaUsuario(){
		
		$mysql = new mysql();
		
		$query = "
			select
				ID,
				NOME,
				LOGIN,
				case when ATIVO = 1 then 'Ativo' else 'Bloqueado' end ATIVO,
				DATA_ATUALIZACAO,
				EMAIL
			from
			fx_usuarios 
		;";
		$result = $mysql->sql($query);
		
		return($result);	
	}
	
	function incluirUsuario($dados){
		
		$mysql = new mysql();
		
	$query = "
			insert into fx_usuarios
			(`NOME`,
            `LOGIN`,
            `SENHA`,
            `ATIVO`,
            `DATA_ATUALIZACAO`,
            `EMAIL`,
            `ID_PERFIL`,
            `CEL`)
          values
             ('$dados[user_name]',
              '$dados[user_login]',
              password('logar123'),
              1,
              sysdate(),
              '$dados[user_email]',
              '$dados[id_perfil]',
              '$dados[user_mobile]');";
                       
		$result = $mysql->sql($query);
        
        $ip = $_SERVER['REMOTE_ADDR'];
        $user = "error";
        
        $log_query ="INSERT INTO `lmgava_my_sis`.`ac_log`
(`LOGIN`,
`DATA_HORA_LOGIN`,
`IP`,
`PAGINA`,
`ACAO`)
VALUES
('$user',
now(),
'$ip',
'int_adm_user.php',
'New user created');";

	$result = $mysql->sql($log_query);
		
		
	}

	function excluirUsuario($id_usuario){
		
		$mysql = new mysql();
		
		$query = "
			delete from fx_usuarios
			where ID = '$id_usuario'
		;";
		$result = $mysql->sql($query);
	}
	
	function resetarSenha($id_usuario){
		
		$mysql = new mysql();
		
		$query = "
			update fx_usuarios
			set SENHA = password('mycube')
			where ID = '$id_usuario'
		;";
		$result = $mysql->sql($query);
	}
	
	function alterarUsuario($dados){
		
		$mysql = new mysql();
		
		if(empty($dados[id_status])){
			$id_status = 0;
		}

		$query = "
			update fx_usuarios
			set
                `ID` = '$dados[hi_user_id]',
                `NOME` = '$dados[user_name]',
                `LOGIN` = '$dados[user_login]',                
                `ATIVO` = '$dados[user_active]',
                `DATA_ATUALIZACAO` = sysdate(),
                ID_PERFIL = '$dados[id_perfil]',
                `EMAIL` = '$dados[user_email]',
                `CEL` = '$dados[user_mobile]'
                
			where
				ID = '$dados[hi_user_id]'
			;";
		$result = $mysql->sql($query);
		
		
	}
	
	
	function getPerfil($usuario){
		
		$mysql = new mysql();
		
		$query = "
			select
				fx_perfil.NOME
			from
			fx_usuarios

			inner join rc_usuario_perfil
			on fx_usuarios.ID = rc_usuario_perfil.ID_USUARIO

			inner join fx_perfil
			on fx_perfil.ID = rc_usuario_perfil.ID_PERFIL


			where
			fx_usuarios.LOGIN = '$usuario'
		;";
		$result = $mysql->sql($query);
		
		$line = mysqli_fetch_array($result);
		
		return($line['NOME']);
	}
	
	
	function getIdPerfil($usuario){
		
		$mysql = new mysql();
		
		$query = "
			select
				fx_perfil.ID
			from
			fx_perfil

			inner join rc_usuario_perfil
			on fx_perfil.ID = rc_usuario_perfil.ID_PERFIL

			inner join fx_usuarios
			on fx_usuarios.ID = rc_usuario_perfil.ID_USUARIO

			where
			fx_usuarios.LOGIN = '$usuario'
		;";
		$result = $mysql->sql($query);
		
		$line = mysqli_fetch_array($result);
		
		return($line['ID']);
	}
	
	
	function getNome($usuario){
		
		$mysql = new mysql();
		
		$query = "
			select
				NOME
			from
				fx_usuarios

			where LOGIN = '$usuario'
		;";
		$result = $mysql->sql($query);
		
		$line = mysqli_fetch_array($result);
		
		return($line['NOME']);
	}
	
	
	function getEmail($usuario){
		
		$mysql = new mysql();
		
		$query = "
			select
				EMAIL
			from
				fx_usuarios

			where LOGIN = '$usuario'
		;";
		$result = $mysql->sql($query);
		
		$line = mysqli_fetch_array($result);
		
		return($line['EMAIL']);
	}
	
	
	function getUsuario($id_usuario){
		
		$mysql = new mysql();
		
		$query = "
			select
				LOGIN
			from
				fx_usuarios

			where ID = '$id_usuario'
		;";
		$result = $mysql->sql($query);
		
		$line = mysqli_fetch_array($result);
		
		return($line['LOGIN']);
	}
	
	
	function getStatus($id_usuario){
		
		$mysql = new mysql();
		
		$query = "
			select
				ATIVO
			from
				fx_usuarios

			where ID = '$id_usuario'
		;";
		$result = $mysql->sql($query);
		
		$line = mysqli_fetch_array($result);
		
		return($line['ATIVO']);
	}


function printUsers(){
    	
        		$mysql = new mysql();
		
        
        $query = "
			SELECT
    fx_usuarios.ID, 
    fx_usuarios.NOME, 
    fx_usuarios.LOGIN, 
    SENHA, 
    ATIVO,
     DATA_ATUALIZACAO, 
     EMAIL, 
     ID_EMPRESA, 
     CEL, 
     IMG, 
     NOTAS,
      ANIVERSARIO,
       RESET_CODE,
        RESET_TIME,
         fx_usuarios.ID_PERFIL,  
          left(fx_perfil.NOME,3) as USER_PROFILE,  
    date_format(LAST_LOGIN,'%d/%m') AS LAST_LOGIN, dif_dias
FROM
    lmgava_my_sis.fx_usuarios left join lmgava_my_sis.last_login 
     on (fx_usuarios.login = last_login.login)
     left join lmgava_my_sis.fx_perfil on (fx_usuarios.id_perfil = fx_perfil.id);
     
		;";
        
		$result = $mysql->sql($query);
	   
       $tag = '';
    	
		while($line = mysqli_fetch_array($result)){
		  
               $tag_data="";
           $tag_data.= ' data-id="'.$line["ID"].'" ';
            $tag_data.= ' data-user_login="'.$line["LOGIN"].'" ';
           $tag_data.= ' data-user_mobile="'.$line["CEL"].'" ';
           $tag_data.= ' data-user_name="'.$line["NOME"].'" ';
           $tag_data.= ' data-user_active="'.$line["ATIVO"].'" ';
           $tag_data.= ' data-user_email="'.$line["EMAIL"].'" ';



          if($line["ATIVO"]==1){ $status = '<span class="badge bg-soft-success text-success">Active</span>'; } else 
          { $status = '<span class="badge bg-soft-danger text-danger">Blocked</span>'; }
		  
	 $tag.= '<tr>
                                                 
                                                        <td class="table-user">
                                                            <img src="../assets/images/users/'.$line["IMG"].'" alt="table-user" class="mr-2 rounded-circle">
                                                            <a href="javascript:void(0);" class="text-body font-weight-semibold">'.$line["NOME"].'</a>
                                                        </td>
                                                        <td>'.$line["CEL"].'
                                                        </td>
                                                        <td>
                                                            '.$line["EMAIL"].'
                                                        </td>
                                                        <td>
                                                            '.$line["USER_PROFILE"].'
                                                        </td>
                                                        <td>
                                                           '.$line["LAST_LOGIN"].'
                                                        </td>
                                                        <td>
                                                            '.$status.'
                                                        </td>
                    
                                                        <td>
                                                            <a href="javascript:void(0);" class="action-icon" data-toggle="modal" data-target="#edit-modal" '.$tag_data.'> <i class="mdi mdi-square-edit-outline"></i></a>
                                                            <a href="javascript:void(0);" class="action-icon" data-toggle="modal" data-target="#del-modal" data-id="'.$line["ID"].'"> <i class="mdi mdi-delete"></i></a>
                                                            <a href="javascript:void(0);" class="action-icon" data-toggle="modal" data-target="#lock-modal"  data-id="'.$line["ID"].'"> <i class="mdi mdi-lock"></i></a>
                                                            <a href="javascript:void(0);" class="action-icon" data-toggle="modal" data-target="#reset-modal"  data-id="'.$line["ID"].'"> <i class="mdi mdi-textbox-password"></i></a>
                                                        </td>
                                                    </tr>';
                                                    
                                                    
         
    
		}
  
     return($tag);
    
    
}

function printPerfil($id_perfil){
    
    	$mysql = new mysql();
		
        $query = "
				SELECT
    ID,
    NOME
    FROM
    lmgava_my_sis.fx_perfil;
		;";
        
		$result = $mysql->sql($query);
 
 $tag='';
 while($line = mysqli_fetch_array($result)){
    
    if($line["ID"]==$id_perfil){ $selected = "selected"; }else{ $selected="";}
    
    $tag.='<option value="'.$line["ID"].'" '.$selected.'>'.$line["NOME"].'</option>';
    
    
 }
 
 return($tag);
    
}


 function getDados($id){
    
  		$mysql = new mysql();
		
        $query = "
			select
			`fx_usuarios`.`ID`,
            `fx_usuarios`.`NOME`,
            `fx_usuarios`.`LOGIN`,
            `fx_usuarios`.`SENHA`,
            `fx_usuarios`.`ATIVO`,
            `fx_usuarios`.`DATA_ATUALIZACAO`,
            `fx_usuarios`.`EMAIL`,
            `fx_usuarios`.`ID_EMPRESA`,
            fx_empresa.EMPRESA,
            `fx_usuarios`.`CEL`,
            `fx_usuarios`.`IMG`,
            `fx_usuarios`.`NOTAS`,
            DATE_FORMAT(`fx_usuarios`.`ANIVERSARIO`,'%d/%m/%Y') AS NIVER
			from
				fx_usuarios
                LEFT JOIN fx_empresa ON (fx_usuarios.id_empresa = fx_empresa.id_empresa)
                

			where (ID = '$id' OR LOGIN = '$id')
		;";
		$result = $mysql->sql($query);
		
		$line = mysqli_fetch_array($result);
  
$dados["nome_usuario"]    = $line['NOME'];
$dados["login_usuario"]   = $line['LOGIN'];
$dados["email"]           = $line['EMAIL'];
$dados["cel"]             = $line['CEL'];
$dados["atualizacao"]     = $line['DATA_ATUALIZACAO'];
$dados["id_empresa"]      = $line['ID_EMPRESA'];
$dados["niver"]           = $line['NIVER'];
$dados["notas"]           = $line['NOTAS'];
$dados["id_usuario"]      = $line['ID'];
$dados["ativo"]           = $line['ATIVO'];
$dados["empresa"]         = $line['EMPRESA'];
$dados["senha"]           = $line['SENHA'];
$dados["img"]             = $line['IMG'];

    return ($dados);
        
     }
     
     function getImg($id){
        
        
        $mysql = new mysql();
		
		$query = "
			select
				IMG
			from
				fx_usuarios

			where ID = '$id'
		;";
		$result = $mysql->sql($query);
		
		$line = mysqli_fetch_array($result);
		
		return($line['IMG']);
        
     }
     
     
  function testeSenha($senha,$id_usuario){
    $mysql = new mysql();
    		$query = "
			 SELECT
				(CASE WHEN SENHA='$senha' then SENHA else PASSWORD('$senha') end) AS TROCAR
			from
				fx_usuarios
			WHERE
             ID = '$id_usuario';        
            
		;";
		$result = $mysql->sql($query);
		
		$line = mysqli_fetch_array($result);
		
		return($line['TROCAR']);
    
    
  }
  
  function alterarPerfil($dados){
    
    	$mysql = new mysql();
		

   $query = "
			update fx_usuarios
	   		set
                 
                `NOME` = '$dados[nome_usuario]',
                `LOGIN` = '$dados[login_usuario]',
                `DATA_ATUALIZACAO` = sysdate(),
                `EMAIL` = '$dados[email]',                
                `CEL` = '$dados[cel]',
                `ANIVERSARIO` = '$dados[niver]',
                IMG =  '$dados[img]',
                SENHA = '$dados[senha]'

			where
				ID = '$dados[id_usuario]'
			;";
		$result = $mysql->sql($query);
    
    
  }
 
 function lockUser($user_id, $value){
    
    	$mysql = new mysql();
		

   $query = "
			update lmgava_my_sis.fx_usuarios
	   		set
                ATIVO = '$value'
			where
				ID = '$user_id'
			;";
		$result = $mysql->sql($query);
    
    return (1);
    
     }
     
      
  
}
?>
