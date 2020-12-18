<?php

class ac_export{


function listarRel(){

$mysql = new mysql();

$query ="SELECT 
			id_relatorio,
			RELATORIO,
			RESPONSAVEL,
			ATIVO,
            FONTE
		FROM `ac_export`";

         $result = $mysql->sql($query);
         
return ($result);

}


function listarRelBi(){

$mysql = new mysql();

$query ="SELECT 
			id_relatorio,
			RELATORIO,
			RESPONSAVEL,
			ATIVO,
			VARIAVEIS
		FROM `ac_export`
		where
		RESPONSAVEL = 'Onebi'";

         $result = $mysql->sql($query);
         
return ($result);

}


function dadosRel($id){
    
    $mysql = new mysql();
    
    $query ="SELECT 
            `id_relatorio`, 
            `query`,
             `campos`,
              `fonte`, 
              `title`, 
              `ATIVO`, 
              `RELATORIO`,
              `RESPONSAVEL`, 
              `VARIAVEIS`
		FROM `lmgava_my_sis`.`ac_export`
        WHERE
        id_relatorio = '$id';";

         $result = $mysql->sql($query);
         
         $line = mysqli_fetch_array($result);
         
$dados['id_relatorio'] = $line["id_relatorio"];
$dados['query']	     = $line["query"];
$dados['campos']	 	 = $line["campos"];
$dados['fonte'] 	     = $line["fonte"];
$dados['variaveis']	 = $line["VARIAVEIS"];
$dados['titulo']		 = $line["title"];
$dados['relatorio']	 = $line["RELATORIO"];
$dados['responsavel']	 = $line["RESPONSAVEL"];

if($line["ATIVO"]==1)
		{ $dados['ativo']='Checked';}
	else{$dados['ativo']='';}

return ($dados);    
    
}

function editModalValues($id){
    
    $mysql = new mysql();
    
    $query = "SELECT
id_relatorio, query, campos, fonte, title, ATIVO, RELATORIO, responsavel, VARIAVEIS
FROM
lmgava_my_sis.ac_export
WHERE
id_relatorio = '$id';";
    
    
            $result = $mysql->sql($query);
    
    $tag ="";
    
    	$line = mysqli_fetch_array($result);
    	   
           $tag.= ' data-id="'.$line["id_relatorio"].'" ';
           $tag.= ' data-query="'.$line["query"].'" ';
           $tag.= ' data-campos="'.$line["campos"].'" ';
           $tag.= ' data-fonte="'.$line["fonte"].'" ';
           $tag.= ' data-title="'.$line["title"].'" ';
           $tag.= ' data-relatorio="'.$line["RELATORIO"].'" ';
           $tag.= ' data-responsavel="'.$line["responsavel"].'" ';
           $tag.= ' data-variaveis="'.$line["VARIAVEIS"].'" ';
           
           return($tag);
           
}


function incluirRel($query,$campos,$fonte,$titulo,$ativo,$relatorio,$responsavel,$variaveis){

$mysql = new mysql();

$query = "INSERT INTO `ac_export`
(`query`, `campos`, `fonte`, `title`, `ATIVO`, `RELATORIO`, `RESPONSAVEL`, `VARIAVEIS`) VALUES 
('$query',
 '$campos',
 '$fonte',
 '$titulo',
 '$ativo',
 '$relatorio',
 '$responsavel',
 '$variaveis')";

$result = $mysql->sql($query);

return 1;         

}


function updateRel($id_report,$query,$campos,$fonte,$titulo,$ativo,$relatorio,$responsavel,$variaveis){
   
   $mysql = new mysql();
   
   
   
    $query = "UPDATE ac_export
                SET
        `query`       = '$query',
        `campos`      = '$campos',
        `fonte`       = '$fonte',
        `title`       = '$titulo',
        `ATIVO`       = '$ativo',
        `RELATORIO`   = '$relatorio',
        `RESPONSAVEL` = '$responsavel', 
        `VARIAVEIS`   = '$variaveis' 
             WHERE
        ID_RELATORIO = '$id_report';";

        $result = $mysql->sql($query);
        
        return 1;
}


function excluir($id){
     
    $mysql = new mysql();
    
    $query = "DELETE FROM `ac_export`
             WHERE
        ID_RELATORIO = '$id';";

      $result = $mysql->sql($query);
      
      return 1;
    }
    
    
    
    
function printFilter($id_rel,$type,$campo,$selected){
    
     $mysql = new mysql();
    
    $query_up = "SELECT DISTINCT ".$campo." FROM lmgava_my_sis.temp_ac_export".$id_rel." order by ".$campo." ASC";
  $result = $mysql->sqlOn($query_up);
    
    
  if($type==1){ 
  
    $tag = ' <div class="col-auto">
                                                    <label class="sr-only" for="inlineFormInput">Name</label>
                                                    <select class="form-control mb-2" name="'.$campo.'" id="'.$campo.'">
	<option value="%"> - '.$campo.' - </option>';
    
  while($line = mysqli_fetch_array($result)){ 
    
    if($selected==$line[$campo]) { $tag_selected = "Selected"; } else { $tag_selected=""; }
    
            $tag.='<option '.$tag_selected .' value="'.$line[$campo].'">'.$line[$campo].'</option>';
        }
     
           $tag.='</select></div>';
                                                
           }                          
           
  
  if($type==2){ 
  
  

   
   
   
  
    $tag = ' <div class="col-auto">
             <select multiple="multiple" class="multi-select" id="mult_'.$campo.'" name="mult_'.$campo.'[]" data-plugin="multiselect">
                                                
                                             
	<option value="%"> - '.$campo.' - </option>';
    
  while($line = mysqli_fetch_array($result)){ 
   
    
    //print_r($selected);
    $tag_selected = "";
    
    
    if(isset($selected)){
   foreach($selected as $value){
   
       if($value==$line[$campo]) { $tag_selected = "Selected"; };
     }
   }
   
   
    
            $tag.='<option '.$tag_selected .' value="'.$line[$campo].'">'.$line[$campo].'</option>';
            
            $tag_selected="";
            
        }
     
           $tag.='</select></div>';
                                                
           }                          
  
  
           
    	
      
                                                
                                                return($tag);
    
}

function printFilter2($id_rel,$campo,$selected){
    
    
        
     $mysql = new mysql();
    
    $query_up = "SELECT DISTINCT ".$campo." FROM lmgava_my_sis.temp_ac_export".$id_rel." order by ".$campo." ASC";
  $result = $mysql->sqlOn($query_up);
  

    
    $tag = ' <div class="col-auto">
                                                
                                                        
                                                    <select id="selectize-optgroup" multiple class="form-control mb-2" name="'.$campo.'" id="'.$campo.'">
	<option value="%"> - '.$campo.' - </option>';
    
  while($line = mysqli_fetch_array($result)){ 
    
    if($selected==$line[$campo]) { $tag_selected = "Selected"; } else { $tag_selected=""; }
    
            $tag.='<option '.$tag_selected .' value="'.$line[$campo].'">'.$line[$campo].'</option>';
        }
     
           $tag.='</select></div>';
                                                
                                                
                                                
}

function printtest(){
    
    $tag ='<div class="col-auto">
            
                                                <select multiple="multiple" class="multi-select" id="my_multi_select1" name="my_multi_select1[]" data-plugin="multiselect">
                                                    <option>Dallas Cowboys</option>
                                                    <option>New York Giants</option>
                                                    <option selected>Philadelphia Eagles</option>
                                                    <option selected>Washington Redskins</option>
                                                    <option>Chicago Bears</option>
                                                    <option>Detroit Lions</option>
                                                    <option>Green Bay Packers</option>
                                                    <option>Minnesota Vikings</option>
                                                    <option selected>Atlanta Falcons</option>
                                                    <option>Carolina Panthers</option>
                                                    <option>New Orleans Saints</option>
                                                    <option>Tampa Bay Buccaneers</option>
                                                    <option>Arizona Cardinals</option>
                                                    <option>St. Louis Rams</option>
                                                    <option>San Francisco 49ers</option>
                                                    <option>Seattle Seahawks</option>
                                                </select>
    
                                            </div>';
                                            
    return ($tag);
    
    
}

function listFilter($id_rel){
    
     $mysql = new mysql();
    
    $query = "SELECT `ac_export_trans`.`ID_TRANS`,
    `ac_export_trans`.`ID_RELATORIO`,
    `ac_export_trans`.`FIELD`,
    `ac_export_trans`.`ID_TYPE`
FROM `lmgava_my_sis`.`ac_export_trans`
where
ID_RELATORIO = '$id_rel';
";
    $result = $mysql->sql($query);
  
   return($result);
  
    

}

function addFilter($id_rel,$field,$check_type){
    
    $mysql = new mysql();
    
    $query = "INSERT INTO `lmgava_my_sis`.`ac_export_trans`
        (`ID_RELATORIO`,
        `FIELD`,
        `ID_TYPE`)
      VALUES
        ('$id_rel',
        '$field',
        '$check_type');";

    $result = $mysql->sql($query);
    
}

function delFilter($id_trans){
    
    $mysql = new mysql();
    
    $query = "DELETE FROM `lmgava_my_sis`.`ac_export_trans`
                WHERE
                ID_TRANS = '$id_trans';";

    $result = $mysql->sql($query);
    
}



}

?>