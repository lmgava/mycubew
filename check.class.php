<?php

/**
 * @author 
 * @copyright 2020
 */


class check{


/* Include functions */
    
     function check_create($database,$table,$temp_table,$field,$check_type,$check_values){
                
        $mysql = new mysql;
        
          $query="INSERT INTO `lmgava_my_app`.`ch_table`
                            (
                            `table_name`,
                            `temp_table`,
                            `tab_field`,
                            `check_type`,
                            `database`,
                            `check_values`
                            )
                            VALUES
                            (
                            '$table',
                            '$temp_table',
                            '$field',
                            '$check_type',
                            '$database','$check_values');";
                            
              $result_check = $mysql->sql($query);
               
                      
     }
     

     function checkLoad_create($database,$csv_address,$csv_num_fields,$table_name, $temp_table,$sql_procedure,$report_id){
     /* id_check_file, csv_address, csv_num_fields, table_name, temp_table, ATIVO, SQL_PROCEDURE, REPORT_ID*/


          
        $mysql = new mysql;
        
         $query="INSERT INTO `lmgava_my_app`.`ch_check_file`
                        ('database'
                        `csv_address`,
                        `csv_num_fields`,
                        `table_name`,
                        `temp_table`,
                        `ATIVO`,
                        `SQL_PROCEDURE`,
                        `REPORT_ID`)
                        VALUES
                        (
                        '$database',
                        '$csv_address',
                        '$csv_num_fields',
                        '$table_name',
                        '$temp_table',
                        '1',
                        '$sql_procedure',
                        '$report_id');";
                            
         $result_check = $mysql->sql($query);
          
        
     }
    
    function editCheckValues($id_check){
        
        
                  
       $mysql = new mysql;
        
      $query = " SELECT `ch_table`.`id_check`,
    `ch_table`.`table_name`,
    `ch_table`.`temp_table`,
    `ch_table`.`tab_field`,
    `ch_table`.`format`,
    `ch_table`.`check_type`,
    `ch_table`.`database`,
    `ch_table`.`ATIVO`,
    `ch_table`.`CHECK_VALUES`
FROM `lmgava_my_app`.`ch_table`
where
ID_CHECK = '$id_check'";
        
        $result = $mysql->sql($query);
    
    $tag ="";
    
    	$line = mysqli_fetch_array($result);
    	   
           $tag.= ' data-table_name="'.$line["table_name"].'" ';
           $tag.= ' data-field="'.$line["tab_field"].'" ';
           $tag.= ' data-check_type="'.$line["check_type"].'" ';
           $tag.= ' data-database="'.$line["database"].'" ';
           $tag.= ' data-ativo="'.$line["ATIVO"].'" ';
           $tag.= ' data-temp_table="'.$line["temp_table"].'" ';
           $tag.= ' data-CHECK_VALUES="'.$line["CHECK_VALUES"].'" ';
           $tag.= ' data-temp_table="'.$line["temp_table"].'" ';
           
           
        return ($tag);
    
    }
    
    function check_field($field,$database,$table,$temp_table){
        
        
        $mysql = new mysql;
               
        
               
               
        $query_check = "select distinct $field from $database.$temp_table
                    where
            $field not in (SELECT
            distinct $field
            FROM
            $database.$table);";
            
            $result_check = $mysql->sql($query_check);
            
            $linhas = mysqli_num_rows($result_check);
            
            if($linhas==0){ 
            }else{
 
            
            	while($line = mysqli_fetch_array($result_check)) {
    	   
                  $new[] =  $line[$field];
                       
          }
           
           $comma_separated = implode(",", $new);
           
           $msg = "Tabela: ".$database.".".$temp_table." Valores ".addslashes($comma_separated);
           
           
          $query_insert = "INSERT INTO `lmgava_my_app`.`ch_alert`
                (`ALERT_TABLE`,
                    `ALERT_FIELD`,
                `ALERT_DT`,
                `ALERT_ICON`,
                `ALERT_DESC`,
                `DEL`,
                `DEL_DT`,
                `ID_USER`)
                VALUES
                ('$table',
                 '$field',
                                now(),
                'icon-bullhorn',
                '$msg',
                '0',
                '',
                '2');";
           
           
            $result_insert = $mysql->sql($query_insert);

                      return (1);
           
           }

        return(1);
        
        
    }
    
         function check_table($table_name){
        
               $mysql = new mysql;
        
     $query = "
            SELECT `ch_table`.`id_check`,
                `ch_table`.`table_name`,
                `ch_table`.`temp_table`,
                `ch_table`.`tab_field`,
                `ch_table`.`format`,
                `ch_table`.`check_type`,
                `ch_table`.`database`,
                `ch_table`.`CHECK_VALUES`
                
            FROM `lmgava_my_app`.`ch_table`
            where
                `ch_table`.`table_name` =  '$table_name';";
        
        $result = $mysql->sql($query);
        
   return($result);
                          	    
        
    
     }
     
              function check_id($id){
        
               $mysql = new mysql;
        
        $query = "SELECT `ch_table`.`id_check`,
                `ch_table`.`table_name`,
                `ch_table`.`temp_table`,
                `ch_table`.`tab_field`,
                `ch_table`.`format`,
                `ch_table`.`check_type`,
                `ch_table`.`database`,
                `ch_table`.`CHECK_VALUES`
                
            FROM `lmgava_my_app`.`ch_table`
            where
                `ch_table`.`id_check` =  '$id';";
        
        $result = $mysql->sql($query);
        
   return($result);
                          	    
        
    
     }
     
       
       
    function check_list($table){
        
    if(empty($table)){ $table='%';}
         
       $mysql = new mysql;
        
      $query = "SELECT 
            	tab1.`id_check`,
               tab1.`table_name`,
                tab1.`temp_table`,
                tab1.`tab_field`,
                tab1.`format`,
                tab1.`check_type`,
                tab1.`database`,
                 tab1.`ATIVO`,
                 (SELECT
            COUNT(*)
            FROM
            lmgava_my_app.ch_alert
            WHERE
            
            DEL = '0'
            and alert_table = tab1.`table_name` and alert_field = tab1.tab_field) as ACTIVE_ERROS
                FROM `lmgava_my_app`.`ch_table`  as tab1 where tab1.`table_name` like '$table';";
        
        $result = $mysql->sql($query);
    
    return ($result);
    
        
    }
    
    function check_update($id,$database,$table,$temp_table,$field,$check_type,$check_values){
        
         $mysql = new mysql;
        
     $query = "UPDATE `lmgava_my_app`.`ch_table`
                        SET
                        `table_name` = '$table',
                        `temp_table` = '$temp_table',
                        `tab_field` = '$field',
                        `check_type` = '$check_type',
                        `database` = '$database',
                        check_values = '$check_values'
                        WHERE `id_check` = '$id';";
        
        $result = $mysql->sql($query);
    
        
    }
    
    
     function check_listLoad(){
        
         
       $mysql = new mysql;
        
      $query = " 
 SELECT
        id_check_file, csv_address, csv_num_fields, database_name, table_name, temp_table, ATIVO, REPORT_ID,
        (SELECT count(id_check) From lmgava_my_app.ch_table where table_name = tab1.table_name) as fields_checked,
        (SELECT COUNT(ID_CH_ALERT) FROM lmgava_my_app.ch_alert where ALERT_TABLE = tab1.table_name and del=0 and ALERT_FIELD <> 'CSV') as active_errors,
        (SELECT COUNT(ID_CH_ALERT) FROM lmgava_my_app.ch_alert where ALERT_TABLE = tab1.table_name and del=0 and ALERT_FIELD = 'CSV') as active_csv_errors
        FROM
        lmgava_my_app.ch_check_file as tab1
        ";
        
        $result = $mysql->sql($query);
    
    return ($result);
    
        
    }
    
    function selectTables($table){
        
           
       $mysql = new mysql;
        
      $query = " 
 SELECT
table_name,
(SELECT COUNT(*) AS TOTAL FROM lmgava_my_app.ch_alert where del=0 and ALERT_TABLE = a.table_name) AS ACTIVE_ERRORS
FROM
lmgava_my_app.ch_table  as a
GROUP BY
table_name;

        ";
        
        $result = $mysql->sql($query);
    
    $tag ="";
    
    	while($line = mysqli_fetch_array($result)) {
 	   
       if($table == $line["table_name"]) { $active="active"; }else {$active="";}
    $tag2 = '&nbsp;<span class="badge badge-primary badge-pill">'.$line["ACTIVE_ERRORS"].'</a></span>';
    
    $tag.= '<a class="dropdown-item '.$active.'" href="?table='.$line["table_name"].'">'.$line["table_name"].$tag2.'</a>';
     
     }
     
     $tag.='      <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item" href="?">All</a>';
   
    return ($tag);
   
   
         
    }
    
    
    
    
    function check_error_field($table_name,$field) {
        
           $mysql = new mysql;
        
      $query = "SELECT `ch_alert`.`ID_CH_ALERT`,
                `ch_alert`.`ALERT_TABLE`,
                 `ch_alert`.`ALERT_FIELD`,
                `ch_alert`.`ALERT_DT`,
                `ch_alert`.`ALERT_ICON`,
               left(`ch_alert`.`ALERT_DESC`,60) as ALERT_DESC,
                `ch_alert`.`DEL`,
                `ch_alert`.`DEL_DT`,
                `ch_alert`.`ID_USER`
            FROM `lmgava_my_app`.`ch_alert`
            where
            ALERT_TABLE = '$table_name'
            AND
            ALERT_FIELD = '$field'
            and
            del = 0;";
                    
        $result = $mysql->sql($query);
    
    return ($result);
        
    }
    
    
    
     function check_error($table_name) {
        
           $mysql = new mysql;
        
      $query = "SELECT `ch_alert`.`ID_CH_ALERT`,
                `ch_alert`.`ALERT_TABLE`,
                 `ch_alert`.`ALERT_FIELD`,
                `ch_alert`.`ALERT_DT`,
                `ch_alert`.`ALERT_ICON`,
                left(`ch_alert`.`ALERT_DESC`,60) as ALERT_DESC,
                                `ch_alert`.`DEL`,
                `ch_alert`.`DEL_DT`,
                `ch_alert`.`ID_USER`
            FROM `lmgava_my_app`.`ch_alert`
            where
            ALERT_TABLE like '$table_name'
            and
            del = 0;";
                    
        $result = $mysql->sql($query);
    
    return ($result);
        
    }
    function delCheck($id){
        
               $mysql = new mysql;
        
   $query = "DELETE FROM
                    lmgava_my_app.ch_table
                    WHERE
                    id_check = '$id';";
                    
        $result = $mysql->sql($query);
    
    return (1);
    
    }
    
    
    function delError($idError){
        
                
           $mysql = new mysql;
        
      $query = "update
                    lmgava_my_app.ch_alert
                    set DEL = 1, DEL_DT = now()
                    WHERE
                    ID_CH_ALERT = '$idError';";
                    
        $result = $mysql->sql($query);
    
    return ($query);
    
        
    }
    
    
     function delErrorTab($table){
        
                
           $mysql = new mysql;
        
     $query = "update
                    lmgava_my_app.ch_alert
                    set DEL = 1, DEL_DT = now()
                                       WHERE
                    ALERT_TABLE = '$table';";
                    
        $result = $mysql->sql($query);
    
    return (1);
    
        
    }
    
    
    function delErrorField($table,$field){
        
                
           $mysql = new mysql;
        
             $query = "update
                    lmgava_my_app.ch_alert
                    set DEL = 1
                    WHERE
                    ALERT_TABLE = '$table'
                    and
                    ALERT_FIELD = '$field';";
                    
        $result = $mysql->sql($query);
    
    return (1);
    
        
    }
    
    
    function check_date($field,$database,$table,$temp_table){
        
        
                    
        $mysql = new mysql;
           
           
       $query="SELECT 
                distinct	`$temp_table`.`$field`    
                FROM `$database`.`$temp_table`
                where
                   (( str_to_date($field,'%Y-%m-%d') is null) 
                   or
                   `$temp_table`.`$field`  > '2021-12-31'
                   or
                   `$temp_table`.`$field`  < '2019-01-01');";
    
                  
        $result = $mysql->sql($query);
    
    
    
      $linhas = mysqli_num_rows($result);
            
            if($linhas==0){ 
                
            }else{
 
            
            	while($line = mysqli_fetch_array($result)) {
    	   
                  $new[] =  $line[$field];
                       
          }
           
           $comma_separated = implode(",", $new);
           
           $msg = "Temp Table: ".$database.".".$temp_table." Valores ".addslashes($comma_separated);
           
           
         $query_insert = "INSERT INTO `lmgava_my_app`.`ch_alert`
                (`ALERT_TABLE`,
                `ALERT_FIELD`,
                `ALERT_DT`,
                `ALERT_ICON`,
                `ALERT_DESC`,
                `DEL`,
                `DEL_DT`,
                `ID_USER`)
                VALUES
                ('$table',
                 '$field',
                                now(),
                'icon-bullhorn',
                '$msg',
                '0',
                '',
                '2');";
           
           
            $result_insert = $mysql->sql($query_insert);

                      return (1);
           
           }

    }
    
    function check_num($field,$database,$table,$temp_table){
        
        
                $mysql = new mysql;
           
        
                            $query="SELECT
                  distinct  $field
                    FROM
                    $database.$temp_table
                    where
                    $field not between 0 and 1000";
                    
                      $result = $mysql->sql($query);
    
    
    
      $linhas = mysqli_num_rows($result);
            
            if($linhas==0){ 
                
            }else{
 
            
            	while($line = mysqli_fetch_array($result)) {
    	   
                  $new[] =  $line[$field];
                       
          }
           
           $comma_separated = implode(",", $new);
           
           $msg = "Temp Table: ".$database.$temp_table." - Valores [".addslashes($comma_separated)."]";
           
           
         $query_insert = "INSERT INTO `lmgava_my_app`.`ch_alert`
                (`ALERT_TABLE`,
                `ALERT_FIELD`,
                `ALERT_DT`,
                `ALERT_ICON`,
                `ALERT_DESC`,
                `DEL`,
                `DEL_DT`,
                `ID_USER`)
                VALUES
                ('$table',
                 '$field',
                                now(),
                'icon-bullhorn',
                '$msg',
                '0',
                '',
                '2');";
           
           
            $result_insert = $mysql->sql($query_insert);

                      return (1);
           
           }
                                      
        
    }
    
    function check_in_values ($field,$database,$table,$temp_table,$values){
        
         $mysql = new mysql;
        
        $query = "SELECT
                    distinct $field
                    FROM
                    $database.$temp_table where
                    $field in ($values);";

        $result = $mysql->sql($query);
    
    
    
      $linhas = mysqli_num_rows($result);
            
            if($linhas==0){ 
                
            }else{
 
            
            	while($line = mysqli_fetch_array($result)) {
    	   
                  $new[] =  $line[$field];
                       
          }
           
           $comma_separated = implode(",", $new);
           
           $msg = "Temp Table: ".$database.".".$temp_table." Valores [".addslashes($comma_separated)."]";
           
           
         $query_insert = "INSERT INTO `lmgava_my_app`.`ch_alert`
                (`ALERT_TABLE`,
                `ALERT_FIELD`,
                `ALERT_DT`,
                `ALERT_ICON`,
                `ALERT_DESC`,
                `DEL`,
                `DEL_DT`,
                `ID_USER`)
                VALUES
                ('$table',
                 '$field',
                                now(),
                'icon-bullhorn',
                '$msg',
                '0',
                '',
                '2');";
           
           
            $result_insert = $mysql->sql($query_insert);

                      return (1);
           
           }
                                      
        
    }
    function check_values($field,$database,$table,$temp_table,$values){
                
                $mysql = new mysql;
        
        $query = "SELECT
                    distinct $field
                    FROM
                    $database.$temp_table where
                    $field not in ($values);";

        $result = $mysql->sql($query);
    
    
    
      $linhas = mysqli_num_rows($result);
            
            if($linhas==0){ 
                
            }else{
 
            
            	while($line = mysqli_fetch_array($result)) {
    	   
                  $new[] =  $line[$field];
                       
          }
           
           $comma_separated = implode(",", $new);
           
           $msg = "Temp Table: ".$database.".".$temp_table." Valores [".addslashes($comma_separated)."]";
           
           
         $query_insert = "INSERT INTO `lmgava_my_app`.`ch_alert`
                (`ALERT_TABLE`,
                `ALERT_FIELD`,
                `ALERT_DT`,
                `ALERT_ICON`,
                `ALERT_DESC`,
                `DEL`,
                `DEL_DT`,
                `ID_USER`)
                VALUES
                ('$table',
                 '$field',
                                now(),
                'icon-bullhorn',
                '$msg',
                '0',
                '',
                '2');";
           
           
            $result_insert = $mysql->sql($query_insert);

                      return (1);
           
           }
                                      
        
        
    }
    
    
    function validaCsv($id){
        
        
                        
           $mysql = new mysql;
        
             $query = " 
                 select
                 database_name,
                 id_check_file, csv_address, csv_num_fields, table_name, temp_table, ATIVO
                 from
                 lmgava_my_app.ch_check_file
                 where
                 id_check_file = '$id'";
                    
        $result = $mysql->sql($query);

    $line = mysqli_fetch_array($result);
    
    
    $database = $line["database_name"];
     
     $table_name = $line["table_name"];
     $filename = $line["csv_address"];
     $delimiter = ",";

$row = 1;
	if (($handle = fopen($filename, "r")) !== FALSE) {
$lines=0;
	
	while (($data = fgetcsv($handle, 1000, $delimiter)) !== FALSE) {
			
			$num = count($data);

			//echo "<p> $num fields in line $row: <br /></p>\n";
            
            if($num<>$line["csv_num_fields"]){
            
             $who = ($num <=> $line["csv_num_fields"]);
           
           if($who==1){       
            
                $erro = "CSV Possui um numero maior de colunas. $num vs ".$line["csv_num_fields"];
                     
                     }else{
                              
               $erro = "CSV Possui um numero menor de colunas. $num vs ".$line["csv_num_fields"];
                           }

                
                           
         $query_insert = "INSERT INTO `lmgava_my_app`.`ch_alert`
                (`ALERT_TABLE`,
                `ALERT_FIELD`,
                `ALERT_DT`,
                `ALERT_ICON`,
                `ALERT_DESC`,
                `DEL`,
                `DEL_DT`,
                `ID_USER`)
                VALUES
                ('$table_name',
                 'CSV',
                                now(),
                'icon-bullhorn',
                '$erro',
                '0',
                '',
                '2');";
           
           
            $result_insert = $mysql->sql($query_insert);

                 
                
                }
			$row++;
		
        //	for ($c=0; $c < $num; $c++) {
		//		echo $data[$c] . "<br />\n";
		//	}
        
        break;
		

		}
		fclose($handle);
	}
    
    
          $query_truncate ="truncate ".$database.".".$line["temp_table"];;
          $result_insert = $mysql->sql($query_truncate);
    
         return (1);
    
        
    }
    
    
    function CallProcedure($id){
        
                   $mysql = new mysql;
        
            $query = " 
                 select
                    SQL_PROCEDURE
                 from
                 lmgava_my_app.ch_check_file
                 where
                 id_check_file = '$id'";
                    
        $result = $mysql->sql($query);
    
    
    $line = mysqli_fetch_array($result);
    
    $query = $line["SQL_PROCEDURE"];
    
       $result = $mysql->sql($query);
       
       if (!$result) {
    die('Could not query:' . mysql_error());
}

      
       print $mysql_return = var_dump($result);
       
       return($mysql_return);
           
        
    }
    
    function tempSize($temp_table,$database){
        
          $mysql = new mysql;
        
           $query = "SELECT COUNT(*) AS TOTAL FROM $database.$temp_table;";
                    
        $result = $mysql->sql($query);
    
    
    $line = mysqli_fetch_array($result);
    
    return($line["TOTAL"]);
        
        
    }
    
    function runLoad($temp_table){
        
        $mysql = new mysql;
        
        
        
        $conexao = mysqli_connect('localhost','phpuser','Luasol1020','onebi_test','3308');
        $banco = mysqli_select_db($conexao,'onebi_test');
        mysqli_set_charset($conexao,'utf8');
        
        
             
             $query = " 
                 select
                 database_name,
                 id_check_file, csv_address, csv_num_fields, table_name, temp_table, ATIVO
                 from
                 lmgava_my_app.ch_check_file
                 where
                 temp_table = '$temp_table'";
                    
                $result = $mysql->sql($query);

            $line = mysqli_fetch_array($result);
            
            
             $database = $line["database_name"];
             $temp_table = $line["temp_table"];
             $csv_address = $line["csv_address"];
             
     
     
        
        $query ="truncate ".$database.".".$temp_table.";";
                      
        $sql = mysqli_query($conexao,$query) or die("Erro : ".mysqli_error($conexao)."<b>");
        
      print  $query ="LOAD DATA INFILE '$csv_address' 
                replace INTO TABLE $database.$temp_table
                FIELDS TERMINATED BY ',' 
                ENCLOSED BY '\"'
                LINES TERMINATED BY '\n'
                IGNORE 1 ROWS;";
                        
        
        $sql = mysqli_query($conexao,$query) or die("Erro: ".mysqli_error($conexao)."<b>");
        
    
         return(1);

        
    }
           
    
}

?>