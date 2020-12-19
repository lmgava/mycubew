<?php

session_start();  


	function myAutoload($class) 
 {
 require_once("../classes/".$class.".class.php");
 }

 spl_autoload_register('myAutoload');

$class_login = new login;
$class_log = new log;

if(isset($_GET["code"])){
    
    $reset = $class_login->resetConfirm($_GET["email"],$_GET["code"]);
      if($reset==1){  
        $url = '../new/auth-pwchange.php?email='.$_GET["email"].'&code='.$_GET["code"];
        
       redirect($url);
       
    }else{
        redirect('../interfaces/auth_recoverpw.php');
    }  
}


@$usuario = $_POST['email'];
if(empty($usuario)){ $usuario = $_POST["usuario"];}

@$senha = $_POST['senha'];
@$acao = $_POST['hi_valida'];


switch($acao){
	case 'login':{
	 print $autenticar = $class_login->autenticar($usuario,$senha);     

                
		if($autenticar == "invalido"){
			return(false);
		} elseif($autenticar == "expirado"){
		  
			//redirect('../interfaces/int_atualiza_senha.php');
            $_SESSION['usuario'] = $usuario;           
			$class_log->logUsuario($usuario,'index.php');
			//echo '1';
			redirect('../new/index.php');
			//echo '2';
            
			
		}else{
		
        //$autenticar = $class_login->validarSessao($usuario);     

	
			$_SESSION['email'] = $usuario;        
            redirect('../new/index.php');
			
		}
	}
	break;
	
	case 'logoff':{
		@session_destroy();
		echo "<script language='javascript'>parent.window.location.href='../index.php' </script>";
	}
	break;
    
    
   	case 'reset_password':{
		@session_destroy();
        $url = '../new/auth-confirm-mail.php?email='.$usuario;
        
      //  $class_login->resetEmail($usuario);
        	redirect($url);
		}
	break;
    
}	
?>	