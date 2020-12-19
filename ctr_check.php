<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>

.loader {
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite; /* Safari */
  animation: spin 2s linear infinite;
}

/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>
</head>
<body>

<h2>Loading</h2>

<div class="loader"></div>

</body>
</html>


<?php

function myAutoload($class) 
 {
 require_once("../classes/".$class.".class.php");
 }

 spl_autoload_register('myAutoload');
 
 print_r($_POST);
 print_r($_GET);


        
@$valida = $_POST['hi_valida'];
@$id_error  = $_POST['id_error'];
@$table     = $_POST['table'];



$class_check = new check;


if($valida=='editar'){
    @$id = $_POST["id_check"];
    
        $class_check->check_update($id,$_POST["database"],$_POST["editTable"],$_POST["temp_table"],$_POST["field"],$_POST["check_type"],$_POST["check_values"]);    
       header("Location: /new/int_adm_check.php?act=5");
    
}



if($valida=='excluir'){
    
     $class_check->delError($id_error);    
      //redirect('../interfaces/int_adm_check.php');  
      header("Location: /new/int_adm_check.php");
    
}


if($valida=='excluirCheck'){
    

    @$id = $_POST["delId"];
      $class_check->delCheck($id);    
     //redirect('../interfaces/int_adm_check.php');  
    header("Location: /new/int_adm_check.php?act=6");
    
}

if($valida=='incluir'){
        
    $class_check->check_create($_POST["database"],$_POST["table"],$_POST["temp_table"],$_POST["field"],$_POST["check_type"],$_POST["check_values"]);
     header("Location: /new/int_adm_check.php");
}


if($valida=="delError"){
    
    
        $class_check->delError($id_error);      
         
         $url = "Location: /new/int_adm_check_error.php?table=".$table;
        header($url);
    
}



if($valida=="delAll"){
    
   
       $class_check->delErrorTab($table);      
          header("Location: /new/int_adm_check.php");
}

if($valida=="incluirLoad"){
    

    
    $database = $_POST["database"];
    $csv_address = $_POST["csv_address"];
    $csv_num_fields = $_POST["field_number"];
    $table_name = $_POST["table"];
    $temp_table = $_POST["temp_table"];
    $sql_procedure = $_POST["sql_procedure"];
    $report_id = $_POST["id_report"];
    
    $class_check->checkLoad_create($database,$csv_address,$csv_num_fields,$table_name, $temp_table,$sql_procedure,$report_id);
   // header("Location: /new/int_adm_check_load.php");
    
}

if(empty($valida)){
    

$valida = $_GET["valida"];
@$table  = $_GET["table"];
@$field  = $_GET["field"];
@$id_check = $_GET["id_check"];
@$id_procedure = $_GET["id"];




if($valida=="DelField"){
    
    
       $class_check->delErrorField($table,$field);      
          header("Location: /new/int_adm_check.php");
}





if($valida=="run"){ 
    
    
    $result2 = $class_check->check_table($table);

        	while($line = mysqli_fetch_array($result2)) {
        	   
        	   $check_type = $line["check_type"];
            
   	     if($check_type==2){
             $class_check->check_field($line["tab_field"],$line["database"],$line["table_name"],$line["temp_table"]);
                }
                
         if($check_type==3){
            
             $class_check->check_date($line["tab_field"],$line["database"],$line["table_name"],$line["temp_table"]);
            
         }
         
         if($check_type==5){
            
            $class_check->check_num($line["tab_field"],$line["database"],$line["table_name"],$line["temp_table"]);
            
            
         }
             
        if($check_type==6){
            
            $class_check->check_values($line["tab_field"],$line["database"],$line["table_name"],$line["temp_table"],$line["CHECK_VALUES"]);
            
            
         }
         
         if($check_type==7){
            
             $class_check->check_in_values($line["tab_field"],$line["database"],$line["table_name"],$line["temp_table"],$line["CHECK_VALUES"]);
           
         }
         
                }
                
            header("Location: /new/int_adm_check_load.php?act=3");
                
                
}
    
    

if($valida=="runField"){ 
    
    
    $result2 = $class_check->check_id($id_check);

        	$line = mysqli_fetch_array($result2);
        	
                     

               
        	   $check_type = $line["check_type"];
            
   	     if($check_type==2){
             $class_check->check_field($line["tab_field"],$line["database"],$line["table_name"],$line["temp_table"]);
                }
                
         if($check_type==3){
            
             $class_check->check_date($line["tab_field"],$line["database"],$line["table_name"],$line["temp_table"]);
            
         }
         
         if($check_type==5){
            
            $class_check->check_num($line["tab_field"],$line["database"],$line["table_name"],$line["temp_table"]);
            
            
         }
             
        if($check_type==6){
            
            $class_check->check_values($line["tab_field"],$line["database"],$line["table_name"],$line["temp_table"],$line["CHECK_VALUES"]);
            
            
         }
                      
           
         header("Location: /new/int_adm_check.php");
                
                
}


if($valida=="checkCSV"){
    
        $class_check->validaCsv($id_procedure);
        header("Location: /new/int_adm_check_load.php?act=2");
}


if($valida=="runLoad"){
    
    $class_check->runLoad($table);
     header("Location: /new/int_adm_check_load.php?act=1&row=$lines_affected");
}



if($valida=="CallProcedure"){
    
    $class_check->CallProcedure($id_procedure);
      header("Location: /new/int_adm_check_load.php?act=3");
}



       
}



?>