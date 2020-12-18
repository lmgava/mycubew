<?php

/**
 * @author Gava Leonardo
 * @copyright 2020
 */
 
class pd{
    
    
    function listBus($bu){
        
              
       $mysql = new mysql;
        
      $query = " 
 SELECT
DISTINCT BU
FROM
lmgava_azp.ac_forecast limit 10;

        ";
        
        $result = $mysql->sql($query);
    
    $tag ="";
    
    	while($line = mysqli_fetch_array($result)) {
 	   
       if($bu == $line["BU"]) { $active="active"; }else {$active="";}
    
    
    $tag.= '<a class="dropdown-item '.$active.'" href="?bu='.$line["BU"].'">'.$line["BU"].'</a>';
     
     }
     
     $tag.='      <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item" href="?">All</a>';
   
    return ($tag);
   
        
    }
    
    
        function dataPD($bu){
        
              
       $mysql = new mysql;
        
      $query = " 
SELECT `ac_forecast`.`BU`,
    `ac_forecast`.`LOB`,
    `ac_forecast`.`REF_MONTH`,
    `ac_forecast`.`DESC_MONTH`,
    `ac_forecast`.`VOLUME_2019`,
    `ac_forecast`.`FTE_2019`,
    `ac_forecast`.`VOL_FORECAST_2020`,
    `ac_forecast`.`FTE_FORECAST_2020`,
    `ac_forecast`.`VOLUME_2020`,
    `ac_forecast`.`FTE_2020`,
    `ac_forecast`.`TSL_2020`,
    `ac_forecast`.`VOL_COVID_2020`,
    `ac_forecast`.`FTE_COVID_2020`
FROM `lmgava_azp`.`ac_forecast`
where
BU = 'Austria'
and LOB = 'Vehicle Assistance';";
        
        $result = $mysql->sql($query);
    
    $tag ="";
    
    	while($line = mysqli_fetch_array($result)) {
 	   
       if($bu == $line["BU"]) { $active="active"; }else {$active="";}
    
    
    $tag.= '<a class="dropdown-item '.$active.'" href="?bu='.$line["BU"].'">'.$line["BU"].'</a>';
     
     }
     
     $tag.='      <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item" href="?">All</a>';
   
    return ($tag);
   
        
    }
    
    
    
}



?>