<?php

class mysql {
	
	var $host = "localhost";
	var $user = "phpuser";
	var $pass = "Luasol1020";
	var $db   = "lmgava_my_sis";
		var $port   = "3308";
	
	
	var $query;
	var $link;
	var $result;
	


	function connect(){
			$this->link = mysqli_connect($this->host,$this->user,$this->pass,$this->db,$this->port);
			if(!$this->link){
					echo "<p>Erro na Conexão</p>";
					echo "<p>MySQL retornou:</p>";
					echo mysqli_error();
					die();
			} elseif (!mysqli_select_db($this->link,$this->db)){
					echo "<p>Erro na seleção do Banco de Dados.</p>";
					echo "<p>MySQL retornou:</p>";
					echo mysqli_error($this->link);
					die();
			}
	}
	
	function sql($query){
		
			$this->connect();
            mysqli_query($this->link,"SET NAMES 'utf8';");
			$this->query = $query;	
			
			if($this->result = mysqli_query($this->link,$this->query)){
					$this->disconnect();
					return $this->result;
			} else {
					die("Ocorreu um erro ao executar a Query SQL abaixo:<br>$query<<br><br><b>MySQL Retornou: ".mysqli_error($this->link)."<b>");
					$this->disconnect();
			}
			
	}
    
    	function sqlBase($query,$base){
    	   
           
			$this->connect();
            
            if($base=='app'){ $banco = "use lmgava_my_app"; }
            if($base=='sis'){ $banco = "use lmgava_my_sis"; }
            if($base=='rel'){ $banco = "use lmgava_my_rel"; }
            
            mysqli_query($this->link,$banco);
			
			
            mysqli_query($this->link,"SET NAMES 'utf8';");
			$this->query = $query;
			if($this->result = mysqli_query($this->link,$this->query)){
					$this->disconnect();
					return $this->result;
			} else {
					die("Ocorreu um erro ao executar a Query SQL abaixo:<br>$query<<br><br><b>MySQL Retornou: ".mysqli_error($this->link)."<b>");
					$this->disconnect();
			}
			
	}
	
    function sqlOn($query){
			$this->connect();
            mysqli_query($this->link,"SET NAMES 'utf8';");
			$this->query = $query;
			if($this->result = mysqli_query($this->link,$this->query)){
					
					return $this->result;
			} else {
					die("Ocorreu um erro ao executar a Query SQL abaixo:<br>$query<<br><br><b>MySQL Retornou: ".mysqli_error($this->link)."<b>");
					$this->disconnect();
			}
			 
	}
	function disconnect(){
			return mysqli_close($this->link);
	}
    
    function numCampos($result){
        $this->connect();
        $numLinhas = mysqli_num_fields($result);
        
        return ($numLinhas);
        
    }
    
    function numLinhas($result){
        $this->connect();
        $numLinhas = mysqli_num_rows($result);
        
        return ($numLinhas);
        
    }
    
    function campos($result,$numLinhas){
        $this->connect();
      for($i = 0;$i<$numLinhas; $i++){//Pega o nome dos campos
    	$fields[] =  mysqli_fetch_field_direct($result, $i)->name;
       }
        
        return $fields;
    }
    
    }

?>