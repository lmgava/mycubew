<?php
    
    class myreport {
        
      
  
            

function execTable($query,$campos){ 
         
		     	 $conexao = mysqli_connect('localhost','lmgava_mycube','Luasol1020');
				$banco = mysqli_select_db($conexao,'lmgava_my_app');
				mysqli_set_charset($conexao,'utf8');


           $result= mysqli_query($conexao,$query) or die("Erro");
            
         $numCampos = mysqli_num_fields($result);       
		$numLinhas = mysqli_num_rows($result);		 
            
   
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		
		<title>DataTables example</title>
		
		<!--
		<link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="../datatables/css/DT_bootstrap.css">
-->
		<!-- App css -->
        		<!-- App css -->
		<link href="../../assets/css/bootstrap-material.min.css" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
		<link href="../../assets/css/app-material.min.css" rel="stylesheet" type="text/css" id="app-default-stylesheet" />

		<link href="../../assets/css/bootstrap-material-dark.min.css" rel="stylesheet" type="text/css" id="bs-dark-stylesheet" />
		<link href="../../assets/css/app-material-dark.min.css" rel="stylesheet" type="text/css" id="app-dark-stylesheet" />
        


		<script type="text/javascript" charset="utf-8" language="javascript" src="../../assets/libs/datatables.net/js/jquery.js"></script>
		<script type="text/javascript" charset="utf-8" language="javascript" src="../../datatables/js/jquery.dataTables.js"></script>
		<script type="text/javascript" charset="utf-8" language="javascript" src="../../datatables/js/DT_bootstrap.js"></script>
	</head>
	<body>
		<div class="container" style="margin-top: 10px">
			
<table  id="basic-datatable" cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered">
	
    <thead>  
		<tr>
  <?php 
    //cria o cabeçario, caso não esteja definido na classe
    
        for($i = 0;$i<$numLinhas; $i++){//Pega o nome dos campos 
        echo "<td><b>".$campos[$i]."</b></td>";
		}
         ?>
		
		</tr>
	</thead>
	<tbody>
    <?
			
				while($line = mysql_fetch_array($result, MYSQL_BOTH)) {
		
        echo '<tr class="gradeA">';
        
        for($i = 0;$i<$numCampos; $i++){
      	 echo '<td>'.$line[$i].'</td>';
          }
          
          echo '</tr>';      		    
                   
        
	} ?>
        	
        	
		
		

	</tbody>
</table>
			
		</div>
	</body>
</html>

<?php }

function execReport($id_rel){
    
    $mysql = new mysql();
    
    $busca_query = "SELECT
                    `ac_export`.`query`,	
                    `ac_export`.`campos`,
                    `ac_export`.`fonte`,
                    `ac_export`.`title`,
                     ac_export.variaveis
                FROM lmgava_my_sis.`ac_export`
                     WHERE
                ID_RELATORIO = '$id_rel';";
    
    $result = $mysql->sql($busca_query);
    
    
   $line = mysqli_fetch_array($result);
   
		
    
    $query = $line["query"];
    $campos = explode(',', $line["campos"]);
    
     $alteracoes= substr_count($query, 'GV_');     
         
     $variaveis = array($line["variaveis"]); 
    
		
     
     for($i=0;$i<$alteracoes;$i++){
		 
     $query = str_replace($variaveis[$i],$_GET[$variaveis[$i]], $query);
     
     }
    
          
    
    $result = $mysql->sql($query);            
            
       $numCampos = $mysql->numCampos($result);        
            
         if(empty($campos)){
            $campos = $mysql->campos($result,$numCampos);    
            }
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		
		<title>MyCube | MyReport</title>
		
		<link href="../../assets/css/bootstrap-material.min.css" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
		<link rel="stylesheet" type="text/css" href="../../assets/libs/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="../../assets/datatables.net/css/DT_bootstrap.css">

	<!--	<script type="text/javascript" charset="utf-8" language="javascript" src="../datatables/js/jquery.js"></script>
		<script type="text/javascript" charset="utf-8" language="javascript" src="../datatables/js/jquery.dataTables.js"></script>
		<script type="text/javascript" charset="utf-8" language="javascript" src="../datatables/js/DT_bootstrap.js"></script>
        --!>
                 <!-- third party js -->
        <script src="../../assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="../../assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
        <script src="../../assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
        <script src="../../assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
        <script src="../../assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
        <script src="../../assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
        <script src="../../assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
        <script src="../../assets/libs/datatables.net-buttons/js/buttons.flash.min.js"></script>
        <script src="../../assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
        <script src="../../assets/libs/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
        <script src="../../assets/libs/datatables.net-select/js/dataTables.select.min.js"></script>


	</head>
	<body>
        
            <legend><? echo $line["title"];?></legend>
    <div>
		<!-- <div class="container" style="margin-top: 10px"> -->
			
<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
	
    <thead>  
		<tr>
  <?php 
    //cria o cabeçario, caso não esteja definido na classe
    
        for($i = 0;$i<$numCampos; $i++){//Pega o nome dos campos 
        echo "<td><b>".$campos[$i]."</b></td>";
		}
         ?>
		
		</tr>
	</thead>
	<tbody>
    <?php
				while($line = mysqli_fetch_array($result)) {
		
        echo '<tr class="gradeA">';
        
        for($i = 0;$i<$numCampos; $i++){
      	 echo '<td>'.$line[$i].'</td>';
          }
          
          echo '</tr>';      		    
                   
        
	} ?>
        	
		
		

	</tbody>
</table>
			
		</div>
	</body>
    
        <script src="../../assets/js/vendor.min.js"></script>
        <script src="../../assets/js/pages/datatables.init.js"></script>
        <!-- App js -->
        <script src="../../assets/js/app.min.js"></script>
</html>

<?php }

    
    

}


?>