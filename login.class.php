<?php

/**
 * login
 * 
 * @package 1.2
 * @author Leonardo Gava
 * @copyright 2013
 * @version 1
 * @access public
 */
  
 
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


class login{
    
    function resetEmail($usuario){
        
        $mysql = new mysql();

			
		$query = "
			SELECT
                ATIVO
                FROM
                lmgava_my_sis.fx_usuarios
                WHERE
                EMAIL = '$usuario';";
			
		 $result = $mysql->sqlBase($query,'sis');

		$line = mysqli_fetch_array($result);		
        
    
        
        
        if($line["ATIVO"]==1){
     $chave = sha1(uniqid( mt_rand(), true));
     
     
     	$query_update_key  = "UPDATE lmgava_my_sis.fx_usuarios
                            SET
                            RESET_CODE = '$chave',
                            RESET_TIME = NOW()
                            WHERE
                            EMAIL = '$usuario';";
                                 
	 $result_key = $mysql->sqlBase($query_update_key,'sis');


        $link = "http://localhost/mycubew/controles/ctr_login.php?email=$usuario&code=$chave";
        
        
 
        if( mail($usuario, 'Recuperação de password', 'Olá '.$usuario.', visite este link '.$link) ){
            
         // echo '<p>Foi enviado um e-mail para o seu endereço, onde poderá encontrar um link único para alterar a sua password</p>';
 
        } else {
         // echo '<p>Houve um erro ao enviar o email (o servidor suporta a função mail?)</p>';
 
        }
 
		// Apenas para testar o link, no caso do e-mail falhar
		//echo '<p>Link: '.$link.' (apresentado apenas para testes; nunca expor a público!)</p>';
 
      } else {
        
        //echo '<p>Não foi possível gerar o endereço único</p>';
 
      }
    
            
            
            
        }
        
    function resetConfirm($usuario,$code){
        
        
        	$mysql = new mysql();

			
		$query = "
			SELECT
                    ATIVO
                    FROM
                    lmgava_my_sis.fx_usuarios
                    WHERE
                    RESET_CODE = '$code'
                    AND
                    EMAIL = '$usuario'
                    AND
                    timeDIFF(NOW(),RESET_TIME) < '23:59:59';";
			
		 $result = $mysql->sqlBase($query,'sis');

		$line = mysqli_fetch_array($result);
        
            
            RETURN($line["ATIVO"]);
        		
        
    }
 

	function autenticar($usuario,$senha){
		
		$mysql = new mysql();

			
		$query = "
			select
				ID,
				LOGIN,
				case when timestampdiff(day,DATA_ATUALIZACAO, sysdate()) > 30 then 1 else 0 end VALIDA_ATUALIZACAO
			from
				fx_usuarios
			where
				(LOGIN = '$usuario' OR EMAIL ='$usuario')
				AND
				SENHA = password('$senha') and
				ATIVO = 1;";
			
		 $result = $mysql->sqlBase($query,'sis');

		$line = mysqli_fetch_array($result);		
		$row  = mysqli_fetch_assoc($result);

		 $num_lines = mysqli_num_rows($result);

						
		if($num_lines == 0){
			return("invalido");
				
		}elseif($line['VALIDA_ATUALIZACAO'] == 1){
			return("expirado");		
				
		}else{
			return("valido");
		}
	}
	
	
	function validarSessao(){
		
		$mysql = new mysql();

    	@session_start();
		
		$usuario = $_SESSION['usuario'];		
        
	    $query = "select
				ID,                
                EMAIL,
                IMG
			from
				fx_usuarios
			where
				LOGIN = '$usuario';";
                
 		$result = $mysql->sql($query);
   	    $line = mysqli_fetch_array($result);
		
        	$_SESSION['user_email'] = $line["EMAIL"];
            
           	$_SESSION['user_img'] = $line["IMG"];
            
		if(mysqli_num_rows($result) == 0){
			   
            //   redirect('Location: http://www.mycube.com.br/interfaces/int_sessao_expirada.php');
            //header('Location: http://www.mycube.com.br/interfaces/int_sessao_expirada.php');
		}
	}
    
    function logoff(){        
        session_destroy();
      
//      redirect('Location: http://www.mycube.com.br/');
        //header('Location: http://www.mycube.com.br/');        
    }    
}

?>