<?php
    
    class myexport {

	
	function export_excel($id){

	 $mysql = new mysql();
    
   $busca_query = "SELECT
                    `ac_export`.`query`,	
                    `ac_export`.`campos`,
                    `ac_export`.`fonte`,
                    `ac_export`.`title`,
                     ac_export.variaveis
                FROM lmgava_my_sis.`ac_export`
                     WHERE
                ID_RELATORIO = '$id';";
    
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

			
			


// Criamos uma tabela HTML com o formato da planilha
$html = '';
$html .= '<table>';
$html .= '<tr>';
$html .= '<td colspan="3">'.$line["title"].'</tr>';
$html .= '</tr>';
$html .= '<tr>';

 for($i = 0;$i<$numCampos; $i++){//Pega o nome dos campos 
        $html .='<td><b>'.$campos[$i].'</b></td>';
		}
$html .= '</tr>';
        
while($line = mysqli_fetch_array($result)) {
		
        $html .= '<tr>';
        
        for($i = 0;$i<$numCampos; $i++){
      	 $html .= '<td>'.$line[$i].'</td>';
          }
          
          $html .= '</tr>';      		    
                   
        
	}
		  
$html .= '</table>';

			

return ($html);
			
		
		
		
	}
    
    function export_csv($query){
         $mysql = new mysql();

    $result = $mysql->sql($query);
    $numCampos = $mysql->numCampos($result); 
 
     if(empty($campos)){
            $campos = $mysql->campos($result,$numCampos);    
            }


        
$users = array();

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }
}
 
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=export_test.csv');
$output = fopen('php://output', 'w');
fputcsv($output, $campos);
 
if (count($users) > 0) {
    foreach ($users as $row) {
        fputcsv($output, $row);
    }
}

        
    }
    
    
    
    function export_excel_query($query){

	 $mysql = new mysql();

    $result = $mysql->sql($query);
    $numLinhas = $mysql->numLinhas($result);              
    $numCampos = $mysql->numCampos($result);        
            
         if(empty($campos)){
            $campos = $mysql->campos($result,$numCampos);    
            }

			
			


// Criamos uma tabela HTML com o formato da planilha
$html = '';
$html .= '<table>';
$html .= '<tr>';
$html .= '<td colspan="1">Export</tr>';
$html .= '</tr>';
$html .= '<tr>';

 for($i = 0;$i<$numCampos; $i++){//Pega o nome dos campos 
        $html .='<td><b>'.$campos[$i].'</b></td>';
		}
$html .= '</tr>';
        
while($line = mysqli_fetch_array($result)) {
		
        $html .= '<tr>';
        
        for($i = 0;$i<$numCampos; $i++){
      	 $html .= '<td>'.$line[$i].'</td>';
          }
          
          $html .= '</tr>';      		    
                   
        
	}
		  
$html .= '</table>';

			

return ($html);
			
		
		
		
	}
    

	
	
		
	function export_excel_html($id){

	 $mysql = new mysql();
    
   $busca_query = "SELECT
                    `ac_export`.`query`,	
                    `ac_export`.`campos`,
                    `ac_export`.`fonte`,
                    `ac_export`.`title`,
                     ac_export.variaveis
                FROM lmgava_my_sis.`ac_export`
                     WHERE
                ID_RELATORIO = '$id';";
    
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

			
			


// Criamos uma tabela HTML com o formato da planilha
$html  = '';
$html .= '<table id="basic-datatable" class="table dt-responsive nowrap w-100 table-striped">';
$html .= '<tr>';

 for($i = 0;$i<$numCampos; $i++){//Pega o nome dos campo 
        $html .='<td><b>'.$campos[$i].'</b></td>';
		}
$html .= '</tr>';
        
while($line = mysqli_fetch_array($result)) {
		
        $html .= '<tr>';
        
        for($i = 0;$i<$numCampos; $i++){
      	 $html .= '<td>'.$line[$i].'</td>';
          }
          
          $html .= '</tr>';      		    
                   
        
	}
		  
$html .= '</table>
<script src="../assets/js/vendor.min.js"></script> <script src="../assets/js/pages/datatables.init.js"></script>';

			

return ($html);
			
		
		
		
	}


	

	}	
?>
