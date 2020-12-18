<?php

class log{
    
    
    function logUsuario($usuario,$pagina){
		
		$mysql = new mysql();
		
		$ip = getenv("REMOTE_ADDR");
        $acao = "Logar";
		
		$query = "
			insert into ac_log
			(LOGIN,DATA_HORA_LOGIN,IP,PAGINA,ACAO)
                VALUES
            ('$usuario',sysdate(),'$ip','$pagina','$acao');";
            		
		$result = $mysql->sql($query);
	}
    
        
    function logEmail($usuario,$pagina){
		
		$mysql = new mysql();
		
		$ip = getenv("REMOTE_ADDR");
        $acao = "Exec Cron";
		
		$query = "
			insert into ac_log
			(LOGIN,DATA_HORA_LOGIN,IP,PAGINA,ACAO) values ('$usuario',sysdate(),'$ip','$pagina','$acao')
		;";		
		$result = $mysql->sql($query);
	}
            
    function logAcao($usuario,$pagina,$acao){
		
		$mysql = new mysql();
		
		$ip = getenv("REMOTE_ADDR");
 
		
		$query = "
			insert into ac_log
			(LOGIN,DATA_HORA_LOGIN,IP,PAGINA,ACAO) values ('$usuario',sysdate(),'$ip','$pagina','$acao')
		;";		
		$result = $mysql->sql($query);
	}
    }
    
    
?>