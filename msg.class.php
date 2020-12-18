<?php

class msg{
  
    
    
    //Função para exibir a caixa de entrada do usuario
    
    function caixaEntrada($id_usuario){
        
        $mysql = new mysql;
        
       $query = "SELECT ID_MENSAGEM
					FROM ac_mensageiro
				WHERE 
                D_USER =  '$id_usuario'
						AND
				D_STATUS IN  (0,1);";
        
        $result = $mysql->sql($query);
        
        
        return ($result);
        
        
        
    }
    
    //função para exibir a caixa de saida de um usuário
    function caixaSaida($id_usuario){
        
        
    }
    
    
    //função para ler uma mensagem
function lerMsg($id_msg){
       
	   $mysql = new mysql;
        
       $query = "update `ac_mensageiro` 
			SET 
				D_STATUS = '1'
			WHERE
				ID_MENSAGEM ='$id_msg';";
        
        $result = $mysql->sql($query);
        
        
        return (true);
        
    }
    
    
    //função para deletar uma mensagem (alterar id)
function delMsg($id_msg){
    
    $mysql = new mysql;       
       $query = "delete FROM
					 ac_mensageiro
				WHERE 
                    ID_MENSAGEM = '$id_msg';";
        
        $result = $mysql->sql($query);
    
   }
   
   //função para responder uma mensagem (Idmensagem)
function replyMsg($id_msg){
    
   }
    
    
function numMsg($id_usuario){

       $mysql = new mysql;       
       $query = "SELECT COUNT(ID_MENSAGEM) AS NUM
					FROM ac_mensageiro
				WHERE D_USER =  '$id_usuario'
						AND
				D_STATUS =  '0'
					LIMIT 5;";
        
        $result = $mysql->sql($query);
        
		 $line = mysqli_fetch_array($result);
        
        return ($line["NUM"]);
        
    }
    
    
    function ultimas($id_usuario){
        
    
        $mysql = new mysql;
        
       $query = "SELECT ID_MENSAGEM
					FROM ac_mensageiro
				WHERE 
                D_USER =  '$id_usuario'
						AND
				D_STATUS =  '0'
					LIMIT 5;";
        
        $result = $mysql->sql($query);
        
        
        return ($result);
        
        
    }
    
    function printMsgAlert($id_msg){
        
      $mysql = new mysql;
        
       $query = "SELECT 
                    ID_MENSAGEM,
                    DATA_HORA,
                    (UNIX_TIMESTAMP( NOW( ) ) - UNIX_TIMESTAMP( DATA_HORA )) AS DIF,
                    R_USER,
                    NOME,
                    LEFT(MSG,40) AS MSG,
                    IMG
                FROM `ac_mensageiro` 
                        LEFT JOIN fx_usuarios 
                ON (ac_mensageiro.R_USER = fx_usuarios.ID)
                WHERE
                ID_MENSAGEM = '$id_msg';";
        
        $result = $mysql->sql($query);
        
        $line = mysqli_fetch_array($result);
        
        if($line["DIF"]<'60'){ $dif = 'Alguns Segundos';}
        if($line["DIF"]>'60'){ $dif = round($line["DIF"]/60).' Minutos';}    
        if($line["DIF"]>'3600'){ $dif = round($line["DIF"]/3600).' Horas';}
        if($line["DIF"]>'86400'){  $dif = round($line["DIF"]/86400).' Dias';}


        
        $html = '<a href="/interfaces/int_mensageiro_view.php?id='.$line["ID_MENSAGEM"].'" class="dropdown-item notify-item active">
                                        <div class="notify-icon">
                                            <img src="../assets/images/users/user-1.jpg" class="img-fluid rounded-circle" alt="" /> </div>
                                        <p class="notify-details">'.$line["NOME"].'</p>
                                        <p class="text-muted mb-0 user-msg">
                                            <small>'.$line["MSG"].'</small>
                                        </p>
                                    </a>';
		
	
        
    
        return ($html);
    
    }
	
    function printLast3($id_user){
		
		$msg = new msg;
		
		$result = $msg->ultimas($id_user);

		$tag = "";
		
		while( $line = mysqli_fetch_array($result)){
		
		$tag .=$msg->printMsgAlert($line["ID_MENSAGEM"],0);
		
		
		}
		
		return ($tag);
		
		
		
	}

	
    function printMsg($id_msg, $first=0){
        
        
        
       $mysql = new mysql;
        
       $query = "SELECT 
                    ID_MENSAGEM,
                    DATE_FORMAT(DATA_HORA,'%d/%m as %H:%i') AS DATA_HORA,
                    (UNIX_TIMESTAMP( NOW( ) ) - UNIX_TIMESTAMP( DATA_HORA )) AS DIF,
                    R_USER,
                    R_STATUS,
                    NOME,
                    'PERFIL' AS PERFIL,
                    MSG,
                    IMG
                FROM `ac_mensageiro` 
                        LEFT JOIN fx_usuarios 
                ON (ac_mensageiro.R_USER = fx_usuarios.ID)
                WHERE
                ID_MENSAGEM = '$id_msg';";
        
        
        $result = $mysql->sql($query);
        
        $line = mysqli_fetch_array($result);
        
        if($line["DIF"]<'60'){ $dif = 'Alguns Segundos';}
        if($line["DIF"]>'60'){ $dif = round($line["DIF"]/60).' Minutos';}    
        if($line["DIF"]>'3600'){ $dif = round($line["DIF"]/3600).' Horas';}
        if($line["DIF"]>'86400'){  $dif = round($line["DIF"]/86400).' Dias';}
        
        
      
        

          
        $html = '<tr '.$tag.'>
                  <td>
                     <img src="/img_perfil/'.$line["IMG"].'" class="img-circle avatar hidden-phone" width="50" height="40"/>

                     <a href="user-profile.html" class="name">'.$line["NOME"].'</a><br>
                     <span class="subtext">'.$line["PERFIL"].'</span>
                   </td>
                    <td>'.$line["DATA_HORA"].'</td>
                    <td>'.$line["MSG"].'</td>
                    <td class="align-right">
                     
                     <a href="#responder">'.$msg.'</a> |             
                        <a name="responder" id="'.$id_msg.'" data-toggle="modal" href=#responder data-toggle=tooltip title="Responder"><i class="icon-reply"  id="'.$id_msg.'" ></i></a>|
                        <a name="excluir" id="'.$id_msg.'" data-toggle="modal" href=#excluir data-toggle=tooltip title="Excluir"><i class=icon-remove  id="'.$id_msg.'" ></i></a> 
                      
                     </td>
                     </tr>';
                     
                     
        return ($html);
                            
        
    }
    
    function dadosMsg($id_msg){
        
        
                
        
       $mysql = new mysql;
        
       $query = "SELECT 
                    ID_MENSAGEM,
                    
                    DATE_FORMAT(DATA_HORA,'%d/%m as %H:%i') AS DATA_HORA,
                    TIMEDIFF(now(),DATA_HORA) as DIF,
                    R_USER,
                    D_USER,
                    R_STATUS,
                    NOME,
                    'PERFIL' AS PERFIL,
                    MSG,
                    IMG
                FROM `ac_mensageiro` 
                        LEFT JOIN fx_usuarios 
                ON (ac_mensageiro.R_USER = fx_usuarios.ID)
                WHERE
                ID_MENSAGEM = '$id_msg';";
        
        
        $result = $mysql->sql($query);
        
        $line = mysqli_fetch_array($result);
        
        $dados['id_mensagem'] = $line["ID_MENSAGEM"];
        $dados['data_hora']   = $line["DATA_HORA"];
        $dados['dif']         = $line["DIF"];
        $dados['nome']        = $line["NOME"];
        $dados['msg']         = $line["MSG"];
        $dados['img']         = $line["IMG"];      
        $dados['r_user']      = $line["R_USER"];
        $dados['d_user']      = $line["D_USER"];
        
        return($dados);
        
    }
    
    
    
   //função para lisstar os    
   
   function newMsg($dados){
    
      $mysql = new mysql;
      $dados["msg"] = utf8_encode($dados[msg]);
        
      $r_user = $dados["r_user"];
      $d_user = $dados["d_user"];
      $msg = $dados["msg"];
      $id_reply = $dados["id_reply"];
      
      
      $query = "INSERT INTO `ac_mensageiro`
                    ( 
                      `DATA_HORA`, 
                      `R_USER`, 
                      `R_DATA_HORA`, 
                      `R_STATUS`, 
                      `D_USER`, 
                      `D_DATA_HORA`, 
                      `D_STATUS`, 
                      `MSG`, 
                      
                      `REPLAY`) 
                VALUES 
                    (
                     now(),
                     '$r_user',
                     now(),
                     '1',                     
                     '$d_user',
                     '',
                     '0',
                     '$msg',                     
                     '$id_reply')";
       
    $result = $mysql->sql($query);
    
    return (true);
    
}
    
    
function listaPara($id_usuario){
    
    
     $mysql = new mysql;       
     
       $query = "SELECT
                ID,
                NOME
            FROM `fx_usuarios`
                WHERE
            ID <> '$id_usuario'";
        
        $result = $mysql->sql($query);
        
        
		 while($line = mysqli_fetch_array($result)){
		  
        $tag.='<option value="'.$line["ID"].'">'.$line["NOME"].'</optin>';  
          
		 }
    
    return ($tag);
    
    }
    
   
function printChatId($id){
    
    $mysql = new mysql;
    
          $query = "select
                ID_MENSAGEM, 
                DATA_HORA,
                date_format(R_DATA_HORA,'%H:%m') as DT_MSG,
                R_USER, 
                R_DATA_HORA, 
                R_STATUS, 
                D_USER, 
                D_DATA_HORA, 
                D_STATUS, 
                MSG, 
                REPLAY, 
                R_LOGIN_USER, 
                D_LOGIN_USER

from
lmgava_my_sis.ac_mensageiro
where
ID_MENSAGEM  = '23';";

    $result = $mysql->sql($query);
    
    

    
    $html = '  <li class="clearfix odd">
                                                <div class="chat-avatar">
                                                    <img src="../assets/images/users/-" class="rounded" alt="Geneva M" />
                                                    <i>10:02</i>
                                                </div>
                                                <div class="conversation-text">
                                                    <div class="ctext-wrap">
                                                        <i>Geneva M</i>
                                                        <p>
                                                            Wow thats great  Fucking Great! 
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="conversation-actions dropdown">
                                                    <button class="btn btn-sm btn-link" data-toggle="dropdown"
                                                        aria-expanded="false"><i class="mdi mdi-dots-vertical font-16"></i></button>

                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="#">Copy Message</a>
                                                        <a class="dropdown-item" href="#">Edit</a>
                                                        <a class="dropdown-item" href="#">Delete</a>
                                                    </div>
                                                </div>
                                            </li>';
                                            
    return ($html);

}
   

   }
   
   
?>