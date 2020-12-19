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
@$id_rel  = $_POST['id_rel'];
@$table     = $_POST['table'];


$ac_export = new ac_export;


if($valida=='editar'){
    @$id = $_POST["id_check"];
    
        $class_check->check_update($id,$_POST["database"],$_POST["editTable"],$_POST["temp_table"],$_POST["field"],$_POST["check_type"],$_POST["check_values"]);    
       header("Location: /new/int_adm_check.php?act=5");
    
}




if($valida=='excluir'){
    

    @$id = $_POST["delId"];
    @$id_rel = $_GET["id_rel"];
    
      $ac_export->delFilter($id);    
     //redirect('../interfaces/int_adm_check.php');  
 $url =  "Location: /new/int_adm_myreport_details.php?id_rel=".$id_rel;
    
     header($url);
    
}

if($valida=='incluir'){
        
    $ac_export->addFilter($id_rel,$_POST["field"],$_POST["check_type"]);
    
    $url =  "Location: /new/int_adm_myreport_details.php?id_rel=".$id_rel;
    
     header($url);
}





       



?>