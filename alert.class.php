<?php

class alert{
    
   
 function alert(){ 
    
 }    
    
 
 function listarAlert($id_usuario){
   
       $mysql = new mysql;
        
      $query = "SELECT 
                    `ID_ALERT`
                    
                FROM `ac_alert` 
                    WHERE 
                `ID_USER` = '$id_usuario'
                AND
                DEL = 0
                LIMIT 5 ;";
        
        $result = $mysql->sql($query);
    
    return ($result);
    
 }
 
 function delAlert($id_alert){
    
      $mysql = new mysql;
        
      $query = "UPDATE `ac_alert` 
                SET 
                 `DEL`='1',
                 `DEL_DT`=now()
                WHERE 
                ID_ALERT = '$id_alert';";
        
        $result = $mysql->sql($query);
        
        return (true);
    
 }


 function printAlert($id_alert, $first=0){
 
       $mysql = new mysql;
        
     $query = "SELECT 
                    `ID_ALERT`, 
                    `ALERT_TXT`,
                    `ALERT_LINK`, 
                    
                    `ALERT_ICON`, 
                    `DEL`, 
                    `DEL_DT`,
                     DATE_FORMAT(ALERT_DT,'%d/%m as %H:%i') AS ALERT_DT,
                    (UNIX_TIMESTAMP( NOW( ) ) - UNIX_TIMESTAMP( ALERT_DT )) AS DIF
                FROM `ac_alert` 
                    WHERE 
                ID_ALERT = '$id_alert';";
        
        $result = $mysql->sql($query);
        
        $line = mysqli_fetch_array($result	);
    
            
        if($line["DIF"]<'60'){ $dif = 'Alguns Segundos';}
        if($line["DIF"]>'60'){ $dif = round($line["DIF"]/60).' Minutos';}    
        if($line["DIF"]>'3600'){ $dif = round($line["DIF"]/3600).' Horas';}
        if($line["DIF"]>'86400'){  $dif = round($line["DIF"]/86400).' Dias';}
        
        
       
        if($first==1){ $tag='class="first"';}
        
        
                
        $html = '<tr '.$tag.'>
                  <td>
                    <i class="'.$line["ALERT_ICON"].'"></i>
                   </td>
                    <td>'.$line["ALERT_DT"].'</td>
                    <td>'.$line["ALERT_TXT"].'</td>
                    <td>'.$line["ALERT_LINK"].'</td>
                    <td class="align-right">
                        <a name="excluir" id="'.$line["ID_ALERT"].'" data-toggle="modal" href=#excluir data-toggle=tooltip title="Excluir"><i class=icon-remove  id="'.$line["ID_ALERT"].'" ></i></a>                       
                     </td>
                     </tr>';
                     
                     
        return ($html);    
     
 }

 function printAlertBox($id_alert){
    
          $mysql = new mysql;
        
       $query = "SELECT 
                    `ID_ALERT`, 
                    `ALERT_TXT`,
                    `ALERT_LINK`, 
                    `ALERT_DT`, 
                    `ALERT_ICON`, 
                    `DEL`, 
                    `DEL_DT`,
                    (UNIX_TIMESTAMP( NOW( ) ) - UNIX_TIMESTAMP( ALERT_DT )) AS DIF
                FROM `ac_alert` 
                    WHERE 
                `ID_ALERT` = '$id_alert';";
        
        $result = $mysql->sql($query);
        
        $line = mysqli_fetch_array($result);
    
            
        if($line["DIF"]<'60'){ $dif = 'Alguns Segundos';}
        if($line["DIF"]>'60'){ $dif = round($line["DIF"]/60).' Minutos';}    
        if($line["DIF"]>'3600'){ $dif = round($line["DIF"]/3600).' Horas';}
        if($line["DIF"]>'86400'){  $dif = round($line["DIF"]/86400).' Dias';}
        
        
    $html = '<a href="'.$line["ALERT_LINK"].'" class="item">
                             <i class="'.$line["ALERT_ICON"].'"></i> '.$line["ALERT_TXT"].'
                             <span class="time"><i class="icon-time"></i>'.$dif.'</span>
                         </a>';
    
 return ($html);
    
 }
 
 
 

 function numAlert($id_usuario){
 
       $mysql = new mysql;
        
       $query = "SELECT 
                    COUNT(`ID_ALERT`) AS TOTAL
                    
                FROM `ac_alert` 
                    WHERE 
                `ID_USER` = '$id_usuario'
                AND
                DEL = 0;";
        
        $result = $mysql->sql($query);
        
        $line = mysqli_fetch_array($result);
		
 
    return ($line["TOTAL"]);
 
 }




    }
    
    
?>