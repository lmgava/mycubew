<?php

/**
 * @author Gava Leonardo
 * @copyright 2020
 */

class myChartNew{
    
    
    function insertDash($dash_name,$dash_desc,$login_owner,$owner_only){
        
        $mysql = new mysql();
        
       $query="INSERT INTO `lmgava_my_app`.`ac_dashboard`
                (`NAME_DASH`,
                `DESC_DASH`,
                `ID_OWNER`,
                `OWNER_ONLY`,
                `ACTIVE`)
            VALUES
                ('$dash_name',
                '$dash_desc',
                '$login_owner',
                '1',
                '1');";


  $result = $mysql->sql($query);
        
    }
    
    function pushJSdata($id){
        
        
                
    $mysql = new mysql();
    
       $busca_query = "SELECT `ac_graf_new`.`ID_GRAF`,
    `ac_graf_new`.`TYPE`,
    `ac_graf_new`.`CODE`,
    `ac_graf_new`.`COL`,
    `ac_graf_new`.`VARIABLES`,
    `ac_graf_new`.`SIZE`,
    `ac_graf_new`.`QUERY`  
        FROM `lmgava_my_sis`.`ac_graf_new`
       WHERE
        ID_GRAF = '$id';";
    
   $result = $mysql->sql($busca_query);
   $line = mysqli_fetch_array($result);
   
   
   $query_chart = $line["QUERY"];
   $code = $line["CODE"];
   
   $alteracoes= substr_count($code, 'var_');           
   $variaveis = array();
   
    $variaveis = explode(',',$line["VARIABLES"]);
   
   //print_r($variaveis);
   
    $result_chart = $mysql->sql($query_chart);  
    $line_chart = mysqli_fetch_array($result_chart);
   
   // print_r($line_chart);   
   $var = array();
   
   while($line_chart = mysqli_fetch_array($result_chart)){
   
    $label_array[] = $line_chart[$variaveis[0]]; 
    $data_array1[] = $line_chart[$variaveis[1]];
    @$data_array2[] = $line_chart[$variaveis[2]];
    @$data_array3[] = $line_chart[$variaveis[3]];
    @$data_array4[] = $line_chart[$variaveis[4]];
    @$data_array5[] = $line_chart[$variaveis[5]];
    @$data_array6[] = $line_chart[$variaveis[6]];
    
     
    
    //$data_array2[] = $line[$variaveis[2]];
   }
   
    $tag_label_array = implode('","', $label_array);
    $tag_data_array1 = implode('","', $data_array1);
    $tag_data_array2 = implode('","', $data_array2);
    $tag_data_array3 = implode('","', $data_array3);
    $tag_data_array4 = implode('","', $data_array4);
    $tag_data_array5 = implode('","', $data_array5);
    $tag_data_array6 = implode('","', $data_array6);
  
    
    $labels = '["'.$tag_label_array.'"]';
    $data[1] = '["'.$tag_data_array1.'"]';
    $data[2] = '["'.$tag_data_array2.'"]';
    $data[3] = '["'.$tag_data_array3.'"]';
    $data[4] = '["'.$tag_data_array4.'"]';
    $data[5] = '["'.$tag_data_array5.'"]';
    $data[6] = '["'.$tag_data_array6.'"]';

    
   // $data2 = '["'.$tag_data_array2.'"]';
  
        $var[$variaveis[0]] = $labels;
      for($i=1;$i<$alteracoes;$i++){
     
      $var[$variaveis[$i]] = $data[$i];
      
      }
      
// print "<br>";
 
 //print_r($var);

   
     		
    for($i=0;$i<$alteracoes;$i++){
		 
     $code = str_replace($variaveis[$i],$var[$variaveis[$i]], $code);
     
    }
    
   // print $code;
    
 return ($code);
         
        
    }
    
    
    
    
      function pushJSKlip($id){
        
      
           
                
    $mysql = new mysql();
    
    $busca_query = "SELECT `ac_graf_new`.`ID_GRAF`,
    `ac_graf_new`.`TYPE`,
    `ac_graf_new`.`CODE`,
    `ac_graf_new`.`COL`,
    `ac_graf_new`.`VARIABLES`,
     `ac_graf_new`.`SIZE_WIDTH`,
    `ac_graf_new`.`SIZE_HEIGHT`,
    `ac_graf_new`.`QUERY` 
    
        FROM `lmgava_my_sis`.`ac_graf_new` 
       WHERE
       ID_GRAF = '$id'
       AND
       TYPE = 'jschart';";
    
    $result = $mysql->sql($busca_query);
    
    
   while($line = mysqli_fetch_array($result)){
   
   
   
   $query_chart = $line["QUERY"];
   $code = $line["CODE"];
   
   $alteracoes= substr_count($code, 'var_');           
   $variaveis = array();
   
    $variaveis = explode(',',$line["VARIABLES"]);
   
   //print_r($variaveis);
   
    $result_chart = $mysql->sql($query_chart);  
    $line_chart = mysqli_fetch_array($result_chart);
   
   // print_r($line_chart);   
   $var = array();
   
   $jscode="";
   
   while($line_chart = mysqli_fetch_array($result_chart)){
   
    $label_array[] = $line_chart[$variaveis[0]]; 
    $data_array1[] = $line_chart[$variaveis[1]];
    @$data_array2[] = $line_chart[$variaveis[2]];
    @$data_array3[] = $line_chart[$variaveis[3]];
    @$data_array4[] = $line_chart[$variaveis[4]];
    @$data_array5[] = $line_chart[$variaveis[5]];
    @$data_array6[] = $line_chart[$variaveis[6]];
    
     
    
    //$data_array2[] = $line[$variaveis[2]];
   }
   
    $tag_label_array = implode('","', $label_array);
    $tag_data_array1 = implode('","', $data_array1);
    $tag_data_array2 = implode('","', $data_array2);
    $tag_data_array3 = implode('","', $data_array3);
    $tag_data_array4 = implode('","', $data_array4);
    $tag_data_array5 = implode('","', $data_array5);
    $tag_data_array6 = implode('","', $data_array6);
  
    
    $labels = '["'.$tag_label_array.'"]';
    $data[1] = '["'.$tag_data_array1.'"]';
    $data[2] = '["'.$tag_data_array2.'"]';
    $data[3] = '["'.$tag_data_array3.'"]';
    $data[4] = '["'.$tag_data_array4.'"]';
    $data[5] = '["'.$tag_data_array5.'"]';
    $data[6] = '["'.$tag_data_array6.'"]';

    
   // $data2 = '["'.$tag_data_array2.'"]';
  
        $var[$variaveis[0]] = $labels;
      for($i=1;$i<$alteracoes;$i++){
     
      $var[$variaveis[$i]] = $data[$i];
      
      }
      
// print "<br>";
 
 //print_r($var);

   
     		
    for($i=0;$i<$alteracoes;$i++){
		 
     $code = str_replace($variaveis[$i],$var[$variaveis[$i]], $code);
     
    }
    
   // print $code;
    
    $jscode .= $code;
    
    }
    
   
 return ($jscode);
         
           
      
        
    }
    
     
        
    
    
    function pushJS($id,$var){
        
        
        
        
        
    $mysql = new mysql();
    
    $busca_query = "SELECT `ac_graf_new`.`ID_GRAF`,
    `ac_graf_new`.`TYPE`,
    `ac_graf_new`.`CODE`,
    `ac_graf_new`.`COL`,
    `ac_graf_new`.`VARIABLES`,
    `ac_graf_new`.`SIZE`
        FROM `lmgava_my_sis`.`ac_graf_new`
       WHERE
        ID_GRAF = '$id';";
    
    $result = $mysql->sql($busca_query);
    
    
   $line = mysqli_fetch_array($result);
   
		
    
    $code = $line["CODE"];
    
    $alteracoes= substr_count($code, 'var_');     
         
    $variaveis = explode(',',$line["VARIABLES"]);


    for($i=0;$i<$alteracoes;$i++){
		 
     $code = str_replace($variaveis[$i],$var[$variaveis[$i]], $code);
     
    }
    
 return ($code);
         
        
    }
    
 function  pushCard($var){
      
    $size = $var["size"];
        
    if($size=="single"){
    
    $title = $var["title"];
    $chart_tag = $var["chart_tag"];
    
        
    $html= '<div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                    <div class="card-widgets">
                                            <a href="javascript: void(0);" data-toggle="reload"><i class="mdi mdi-refresh"></i></a>
                                            <a href="javascript: void(0);" data-toggle="remove"><i class="mdi mdi-close"></i></a>
                                        </div>
                                        
                                        <h4 class="header-title">'.$title.'</h4>

                                        <div class="mt-4 chartjs-chart">
                                            <canvas id="'.$chart_tag.'" height="100" class="mt-4"></canvas>
                                        </div>
    
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col -->
                             <!-- end col -->
                        </div>';
                        
                        return ($html);
                        
                        
    }elseif($size=="double"){
        
    $title1 = $var["title1"];
    $chart_tag1 = $var["chart_tag1"];
    
    $title2 = $var["title2"];
    $chart_tag2 = $var["chart_tag2"];
    
    
        $html= ' <div class="row">
                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-body">
                                    <div class="card-widgets">
                                            <a href="javascript: void(0);" data-toggle="reload"><i class="mdi mdi-refresh"></i></a>
                                           
                                            <a href="javascript: void(0);" data-toggle="remove"><i class="mdi mdi-close"></i></a>
                                        </div>
                                        <h4 class="header-title">Pie 2 Chart</h4>
                                        <div class="mt-4 chartjs-chart">
                                            <canvas id="pie-chart-example" height="350" data-colors="#1abc9c,#f1556c"></canvas>
                                        </div>
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col -->
                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-body">
                                    <div class="card-widgets">
                                            <a href="javascript: void(0);" data-toggle="reload"><i class="mdi mdi-refresh"></i></a>
                                           
                                            <a href="javascript: void(0);" data-toggle="remove"><i class="mdi mdi-close"></i></a>
                                        </div>
                                        <h4 class="header-title">Bar Chart</h4>

                                        <div class="mt-4 chartjs-chart">
                                            <canvas id="bar-chart-example" height="350" data-colors="#4a81d4,#e3eaef"></canvas>
                                        </div>
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col -->
                        </div>';
        
        
    }
                        
    
    $html = '  <div class="row">
                            <div class="col-md-6 col-xl-3">
                                <div class="card-box">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="avatar-sm bg-blue rounded shadow-lg">
                                                <i class="fe-aperture avatar-title font-22 text-white"></i>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-right">
                                                <h3 class="text-dark my-1">$<span data-plugin="counterup">12,145</span></h3>
                                                <p class="text-muted mb-1 text-truncate">Income status</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <h6 class="text-uppercase">Target <span class="float-right">60%</span></h6>
                                        <div class="progress progress-sm m-0">
                                            <div class="progress-bar bg-blue" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                                                <span class="sr-only">60% Complete</span>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- end card-box-->
                            </div> <!-- end col -->

                            <div class="col-md-6 col-xl-3">
                                <div class="card-box">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="avatar-sm bg-success rounded shadow-lg">
                                                <i class="fe-shopping-cart avatar-title font-22 text-white"></i>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-right">
                                                <h3 class="text-dark my-1"><span data-plugin="counterup">1576</span></h3>
                                                <p class="text-muted mb-1 text-truncate">Januarys Sales</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <h6 class="text-uppercase">Target <span class="float-right">49%</span></h6>
                                        <div class="progress progress-sm m-0">
                                            <div class="progress-bar bg-success" role="progressbar" aria-valuenow="49" aria-valuemin="0" aria-valuemax="100" style="width: 49%">
                                                <span class="sr-only">49% Complete</span>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- end card-box-->
                            </div> <!-- end col -->

                            <div class="col-md-6 col-xl-3">
                                <div class="card-box">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="avatar-sm bg-warning rounded shadow-lg">
                                                <i class="fe-bar-chart-2 avatar-title font-22 text-white"></i>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-right">
                                                <h3 class="text-dark my-1">$<span data-plugin="counterup">8947</span></h3>
                                                <p class="text-muted mb-1 text-truncate">Payouts</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <h6 class="text-uppercase">Target <span class="float-right">18%</span></h6>
                                        <div class="progress progress-sm m-0">
                                            <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="18" aria-valuemin="0" aria-valuemax="100" style="width: 18%">
                                                <span class="sr-only">18% Complete</span>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- end card-box-->
                            </div> <!-- end col -->

                            <div class="col-md-6 col-xl-3">
                                <div class="card-box">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="avatar-sm bg-info rounded shadow-lg">
                                                <i class="fe-cpu avatar-title font-22 text-white"></i>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-right">
                                                <h3 class="text-dark my-1"><span data-plugin="counterup">178</span></h3>
                                                <p class="text-muted mb-1 text-truncate">Available Stores</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <h6 class="text-uppercase">Target <span class="float-right">74%</span></h6>
                                        <div class="progress progress-sm m-0">
                                            <div class="progress-bar bg-info" role="progressbar" aria-valuenow="74" aria-valuemin="0" aria-valuemax="100" style="width: 74%">
                                                <span class="sr-only">74% Complete</span>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- end card-box-->
                            </div> <!-- end col -->
                        </div>';
                        
                        
    
    
    
 }
 
 
 function dataId($id){
    
    if(empty($id)){ return (0); }
        
    $mysql = new mysql();
    
    $query = "SELECT `ac_graf_new`.`ID_GRAF`,
    `ac_graf_new`.`TYPE`,
    `ac_graf_new`.`CODE`,
    `ac_graf_new`.`COL`,
    `ac_graf_new`.`VARIABLES`,
    `ac_graf_new`.`SIZE_WIDTH`,
    `ac_graf_new`.`SIZE_HEIGHT`,
    `ac_graf_new`.`QUERY` 
        FROM `lmgava_my_sis`.`ac_graf_new`
       WHERE
        ID_GRAF = '$id';";
    
    $result = $mysql->sql($query);
    
    
   $line = mysqli_fetch_array($result);
   
   $data["ID_GRAF"] = $line["ID_GRAF"];
   $data["TYPE"] = $line["TYPE"];
   $data["CODE"] = $line["CODE"];
   $data["VARIABLES"] = $line["VARIABLES"];
   $data["SIZE"] = $line["SIZE"];
   $data["QUERY"] = $line["QUERY"];
   
   
   return($data);
    
    
    
 }
 
 function pushDash($id){
    
      $mysql = new mysql();
    
    $query = "SELECT
ac_dashboard.id_dash, name_dash, desc_dash,
count(distinct row_number) as n_rows,
count(id_dash_row) as n_dash
FROM
lmgava_my_app.ac_dashboard 
inner join lmgava_my_app.ac_dash_row on (ac_dashboard.id_dash = ac_dash_row.id_dash)
group by
id_dash, name_dash, desc_dash;
;";
    
    $result = $mysql->sql($query);
    
    $line = mysqli_fetch_array($result);
        
        $data["id_dash"] = $line["id_dash"];
        $data["name_dash"] = $line["name_dash"];
        $data["desc_dash"] = $line["desc_dash"];
        $data["n_rows"] = $line["n_rows"];
        $data["n_dash"] = $line["n_dash"];
        
          
  return ($data);  
    
    
    
 }
 function pushKlip($id_klip){
    
      $mysql = new mysql();
    
   $query = "SELECT
ID_GRAF, TYPE, CODE, COL, VARIABLES, 
    `SIZE_WIDTH`,
    `SIZE_HEIGHT`, QUERY, GRAF_TITLE, GRAF_DESC, GRAF_SOURCE
FROM
lmgava_my_sis.ac_graf_new
where
ID_GRAF = '$id_klip';";
    
    $result = $mysql->sql($query);
    
    
      $html = '<div class="row">';
      $tag ='';
      
    /*SELECT
ID_DASH_ROW, ID_DASH, ROW_NUMBER, ROW_TAG, CHARTS_ID, CHART_TITLE, CHART_SIZE
FROM
lmgava_my_app.ac_dash_row;
*/
    while($line = mysqli_fetch_array($result)){
    
    $row_tag = 'col-lg-6';
    $charts_id = $line["ID_GRAF"];
    $chart_title = $line["GRAF_TITLE"];
    $chart_size_width = $line["SIZE_WIDTH"];
    $chart_size_height = $line["SIZE_HEIGHT"];
    
    $chart_type = $line["TYPE"];
    
        
    
    if($chart_type=='jschart') { 
    


    
    $tag .='
        <div class="'.$row_tag.'">
                                <div class="card">
                                    <div class="card-body">
                                    <div class="card-widgets">
                                            <a href="javascript: void(0);" data-toggle="reload"><i class="mdi mdi-refresh"></i></a>
                                            <a href="javascript: void(0);" data-toggle="remove"><i class="mdi mdi-close"></i></a>
                                        </div>
                                        <h4 class="header-title">'.$chart_title.'</h4>
                                        <div class="mt-4 chartjs-chart">
                                            <canvas id="myChart'.$charts_id.'" height="'. $chart_size_height.'" width="'.$chart_size_width.'"></canvas>
                                        </div>
                                    </div> <!-- end card-body-->
                                </div> <!-- end card 22-->
                            </div>
                            ';
    
                      
           }
           
    if($chart_type=='target'){
        
        
        
   $query_target = "SELECT
ID_GRAF, TYPE, CODE, COL, VARIABLES,     `SIZE_WIDTH`,
    `SIZE_HEIGHT`, QUERY
FROM
lmgava_my_sis.ac_graf_new
where
id_graf = '$id_klip';";
    
    $result_target = $mysql->sql($query_target);
    
    $line_target = mysqli_fetch_array($result_target);
    
    
    $result_data = $mysql->sql($line_target["QUERY"]);
    
    $line_data = mysqli_fetch_array($result_data);
       
        
        
            $tag .='          <div class="'.$row_tag.'">
                                <div class="card">
                                <div class="card-body">
                                <div class="card-widgets">
                                            <a href="javascript: void(0);" data-toggle="reload"><i class="mdi mdi-refresh"></i></a>
                                            <a href="javascript: void(0);" data-toggle="remove"><i class="mdi mdi-close"></i></a>
                                        </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="avatar-sm">
                                                '.$line_target["CODE"].'
                                                
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-right">
                                                <h3 class="text-dark my-1"><span data-plugin="counterup"> '.$line_data["var_result"].'</span></h3>
                                                <p class="text-muted mb-1 text-truncate"></i>'.$line_data["var_name"].'</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <h6 class="text-uppercase">Target <span class="float-right">'.$line_data["var_target"].'</span></h6>
                                        <div class="progress progress-sm m-0">
                                            <div class="progress-bar bg-blue" role="progressbar" aria-valuenow="'.$line_data["var_percent"].'" aria-valuemin="0" aria-valuemax="100" style="width: '.$line_data["var_percent"].'%">
                                                <span class="sr-only">'.$line_data["var_percent"].' Complete</span>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                </div> <!-- end card-box-->
                            </div> <!-- end col -->
        
                            ';
        
    }
    
    
    if($chart_type=="table"){
        
        
   $query_table = "SELECT
                    ID_GRAF, TYPE, CODE, COL, VARIABLES,     `SIZE_WIDTH`,
    `SIZE_HEIGHT`, QUERY
                    FROM
    lmgava_my_sis.ac_graf_new
                    where
                    id_graf = '$id_klip';";
    
    $result_table = $mysql->sql($query_table);
    
    $line_table = mysqli_fetch_array($result_table);
    
        
    $result_data = $mysql->sql($line_table["QUERY"]);
    
    
    
    $variaveis = explode(',',$line_table["VARIABLES"]);
     
     $numCampos = count($variaveis);
     
    // $tab_title = 
$tag_title="";
foreach ($variaveis as $value) {
    
    
    $tag_title.= "<td>".$value."</td>";
}
    $tag_data="";


				while($line_data = mysqli_fetch_array($result_data)) {
	
        
        $tag_data .=  '<tr>';
        
        for($i = 0;$i<$numCampos; $i++){
            
      	 $tag_data .= '<td>'.$line_data[$i].'</td>';
          
          }
          
          $tag_data . '</tr>';      	

            }
            
    
        
            $tag .='          <div class="'.$row_tag.'">
                                <div class="card">
                                <div class="card-body">
                                <div class="card-widgets">
                                            <a href="javascript: void(0);" data-toggle="reload"><i class="mdi mdi-refresh"></i></a>
                                            <a href="javascript: void(0);" data-toggle="remove"><i class="mdi mdi-close"></i></a>
                                        </div>
                                          <h4 class="header-title">'.$chart_title.'</h4>
                                    <div class="row"  class="table-responsive">
                                    <table class="table table-striped">
                                    <thead>
                                    '.$tag_title.'
                                    </thead>
                                    <tbody class="table-striped">'.$tag_data.' </tbody>
                                    </table>
             
                                    </div>

                                    </div>
                                </div> <!-- end card-box-->
                            </div>';
        
    

    
    }
    
  
        

        
    
    
    
 }
   $html .=$tag.'</div>';
          
  return ($html);  
  
 }
 

  
  function pushRow($id_dash,$id_row){
    
      $mysql = new mysql();
    
   $query = "SELECT
ID_DASH_ROW, ID_DASH, ROW_NUMBER, ROW_TAG, CHARTS_ID, CHART_TITLE,  CHART_SIZE, CHART_TYPE
FROM
lmgava_my_app.ac_dash_row
WHERE
ID_DASH = '$id_dash'
AND 
ROW_NUMBER = '$id_row'
order by row_number asc;";
    
    $result = $mysql->sql($query);
    
    
      $html = '<div class="row">';
      $tag ='';
      
    /*SELECT
ID_DASH_ROW, ID_DASH, ROW_NUMBER, ROW_TAG, CHARTS_ID, CHART_TITLE, CHART_SIZE
FROM
lmgava_my_app.ac_dash_row;
*/
    while($line = mysqli_fetch_array($result)){
    
    $row_tag = $line["ROW_TAG"];
    $charts_id = $line["CHARTS_ID"];
    $chart_title = $line["CHART_TITLE"];
    $chart_size = $line["CHART_SIZE"];

    $chart_type = $line["CHART_TYPE"];
    
        
    
    if($chart_type=='jschart') { 
    


    
    $tag .='
        <div class="'.$row_tag.'">
                                <div class="card">
                                    <div class="card-body">
                                    <div class="card-widgets">
                                            <a href="javascript: void(0);" data-toggle="reload"><i class="mdi mdi-refresh"></i></a>
                                            <a href="javascript: void(0);" data-toggle="remove"><i class="mdi mdi-close"></i></a>
                                        </div>
                                        <h4 class="header-title">'.$chart_title.'</h4>
                                        <div class="mt-4 chartjs-chart">
                                            <canvas id="myChart'.$charts_id.'" height="'. $chart_size.'" ></canvas>
                                        </div>
                                    </div> <!-- end card-body-->
                                </div> <!-- end card 22-->
                            </div>
                            ';
    
                      
           }
           
    if($chart_type=='target'){
        
        
        
   $query_target = "SELECT
ID_GRAF, TYPE, CODE, COL, VARIABLES,
`SIZE_WIDTH`,
    `SIZE_HEIGHT`, QUERY
FROM
lmgava_my_sis.ac_graf_new
where
id_graf = '$charts_id';";
    
    $result_target = $mysql->sql($query_target);
    
    $line_target = mysqli_fetch_array($result_target);
    
    
    $result_data = $mysql->sql($line_target["QUERY"]);
    
    $line_data = mysqli_fetch_array($result_data);
       
        
        
            $tag .='          <div class="'.$row_tag.'">
                                <div class="card">
                                <div class="card-body">
                                <div class="card-widgets">
                                            <a href="javascript: void(0);" data-toggle="reload"><i class="mdi mdi-refresh"></i></a>
                                            <a href="javascript: void(0);" data-toggle="remove"><i class="mdi mdi-close"></i></a>
                                        </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="avatar-sm">
                                                '.$line_target["CODE"].'
                                                
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-right">
                                                <h3 class="text-dark my-1"><span data-plugin="counterup"> '.$line_data["var_result"].'</span></h3>
                                                <p class="text-muted mb-1 text-truncate"></i>'.$line_data["var_name"].'</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <h6 class="text-uppercase">Target <span class="float-right">'.$line_data["var_target"].'</span></h6>
                                        <div class="progress progress-sm m-0">
                                            <div class="progress-bar bg-blue" role="progressbar" aria-valuenow="'.$line_data["var_percent"].'" aria-valuemin="0" aria-valuemax="100" style="width: '.$line_data["var_percent"].'%">
                                                <span class="sr-only">'.$line_data["var_percent"].' Complete</span>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                </div> <!-- end card-box-->
                            </div> <!-- end col -->
        
                            ';
        
    }
    
    
    if($chart_type=="table"){
        
        
   $query_table = "SELECT
                    ID_GRAF, TYPE, CODE, COL, VARIABLES, `SIZE_WIDTH`,
    `SIZE_HEIGHT`, QUERY
                    FROM
    lmgava_my_sis.ac_graf_new
                    where
                    id_graf = '$charts_id';";
    
    $result_table = $mysql->sql($query_table);
    
    $line_table = mysqli_fetch_array($result_table);
    
    
    $result_data = $mysql->sql($line_table["QUERY"]);
    
    
    
    $variaveis = explode(',',$line_table["VARIABLES"]);
     
     $numCampos = count($variaveis);
     
    // $tab_title = 
$tag_title="";
foreach ($variaveis as $value) {
    
    
    $tag_title.= "<td>".$value."</td>";
}
    $tag_data="";



				while($line_data = mysqli_fetch_array($result_data)) {
	
        
        $tag_data .=  '<tr>';
        
        for($i = 0;$i<$numCampos; $i++){
            
      	 $tag_data .= '<td>'.$line_data[$i].'</td>';
          
          }
          
          $tag_data . '</tr>';      	

            }
            
    
        
            $tag .='          <div class="'.$row_tag.'">
                                <div class="card">
                                <div class="card-body">
                                <div class="card-widgets">
                                            <a href="javascript: void(0);" data-toggle="reload"><i class="mdi mdi-refresh"></i></a>
                                            <a href="javascript: void(0);" data-toggle="remove"><i class="mdi mdi-close"></i></a>
                                        </div>
                                          <h4 class="header-title">'.$chart_title.'</h4>
                                    <div class="row"  class="table-responsive">
                                    <table class="table table-striped">
                                    <thead>
                                    '.$tag_title.'
                                    </thead>
                                    <tbody class="table-striped">'.$tag_data.' </tbody>
                                    </table>
             
                                    </div>

                                    </div>
                                </div> <!-- end card-box-->
                            </div>';
        
    

    
    }
    
  
        

        
    
    
    
 }
   $html .=$tag.'</div>';
          
  return ($html);  
  
 }
 
 function pushTargetCard($id){
    
    
    
    $html = ' <div class="row">
                            <div class="col-md-6 col-xl-3">
                                <div class="card-box">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="avatar-sm bg-blue rounded shadow-lg">
                                                <i class="fe-aperture avatar-title font-22 text-white"></i>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-right">
                                                <h3 class="text-dark my-1">$<span data-plugin="counterup">12,145</span></h3>
                                                <p class="text-muted mb-1 text-truncate">Income status</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <h6 class="text-uppercase">Target <span class="float-right">60%</span></h6>
                                        <div class="progress progress-sm m-0">
                                            <div class="progress-bar bg-blue" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                                                <span class="sr-only">60% Complete</span>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- end card-box-->
                            </div> <!-- end col -->

                            <div class="col-md-6 col-xl-3">
                                <div class="card-box">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="avatar-sm bg-success rounded shadow-lg">
                                                <i class="fe-shopping-cart avatar-title font-22 text-white"></i>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-right">
                                                <h3 class="text-dark my-1"><span data-plugin="counterup">1576</span></h3>
                                                <p class="text-muted mb-1 text-truncate">Januarys Sales</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <h6 class="text-uppercase">Target <span class="float-right">49%</span></h6>
                                        <div class="progress progress-sm m-0">
                                            <div class="progress-bar bg-success" role="progressbar" aria-valuenow="49" aria-valuemin="0" aria-valuemax="100" style="width: 49%">
                                                <span class="sr-only">49% Complete</span>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- end card-box-->
                            </div> <!-- end col -->

                            <div class="col-md-6 col-xl-3">
                                <div class="card-box">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="avatar-sm bg-warning rounded shadow-lg">
                                                <i class="fe-bar-chart-2 avatar-title font-22 text-white"></i>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-right">
                                                <h3 class="text-dark my-1">$<span data-plugin="counterup">8947</span></h3>
                                                <p class="text-muted mb-1 text-truncate">Payouts</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <h6 class="text-uppercase">Target <span class="float-right">18%</span></h6>
                                        <div class="progress progress-sm m-0">
                                            <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="18" aria-valuemin="0" aria-valuemax="100" style="width: 18%">
                                                <span class="sr-only">18% Complete</span>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- end card-box-->
                            </div> <!-- end col -->

                            <div class="col-md-6 col-xl-3">
                                <div class="card-box">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="avatar-sm bg-info rounded shadow-lg">
                                                <i class="fe-cpu avatar-title font-22 text-white"></i>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-right">
                                                <h3 class="text-dark my-1"><span data-plugin="counterup">178</span></h3>
                                                <p class="text-muted mb-1 text-truncate">Available Stores</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <h6 class="text-uppercase">Target <span class="float-right">74%</span></h6>
                                        <div class="progress progress-sm m-0">
                                            <div class="progress-bar bg-info" role="progressbar" aria-valuenow="74" aria-valuemin="0" aria-valuemax="100" style="width: 74%">
                                                <span class="sr-only">74% Complete</span>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- end card-box-->
                            </div> <!-- end col -->
                        </div>';
                        
 
 return ($id);
 
   
 }
 
 
 function pushJSDash($dash_id){
    
      
        
                
    $mysql = new mysql();
    
    $busca_query = "SELECT `ac_graf_new`.`ID_GRAF`,
    `ac_graf_new`.`TYPE`,
    `ac_graf_new`.`CODE`,
    `ac_graf_new`.`COL`,
    `ac_graf_new`.`VARIABLES`,
   `ac_graf_new`.`SIZE_WIDTH`,
    `ac_graf_new`.`SIZE_HEIGHT`,
    `ac_graf_new`.`QUERY` 
    
        FROM `lmgava_my_sis`.`ac_graf_new` inner join lmgava_my_app.ac_dash_row on (ac_graf_new.ID_GRAF = ac_dash_row.CHARTS_ID)
       WHERE
       ID_DASH = '$dash_id'
       AND
       TYPE = 'jschart';";
    
    $result = $mysql->sql($busca_query);
    
    
   while($line = mysqli_fetch_array($result)){
   
   
   
   $query_chart = $line["QUERY"];
   $code = $line["CODE"];
   
   $alteracoes= substr_count($code, 'var_');           
   $variaveis = array();
   
    $variaveis = explode(',',$line["VARIABLES"]);
   
   //print_r($variaveis);
   
    $result_chart = $mysql->sql($query_chart);  
    $line_chart = mysqli_fetch_array($result_chart);
   
   // print_r($line_chart);   
   $var = array();
   
   $jscode="";
   
   while($line_chart = mysqli_fetch_array($result_chart)){
   
    $label_array[] = $line_chart[$variaveis[0]]; 
    $data_array1[] = $line_chart[$variaveis[1]];
    @$data_array2[] = $line_chart[$variaveis[2]];
    @$data_array3[] = $line_chart[$variaveis[3]];
    @$data_array4[] = $line_chart[$variaveis[4]];
    @$data_array5[] = $line_chart[$variaveis[5]];
    @$data_array6[] = $line_chart[$variaveis[6]];
    
     
    
    //$data_array2[] = $line[$variaveis[2]];
   }
   
    $tag_label_array = implode('","', $label_array);
    $tag_data_array1 = implode('","', $data_array1);
    $tag_data_array2 = implode('","', $data_array2);
    $tag_data_array3 = implode('","', $data_array3);
    $tag_data_array4 = implode('","', $data_array4);
    $tag_data_array5 = implode('","', $data_array5);
    $tag_data_array6 = implode('","', $data_array6);
  
    
    $labels = '["'.$tag_label_array.'"]';
    $data[1] = '["'.$tag_data_array1.'"]';
    $data[2] = '["'.$tag_data_array2.'"]';
    $data[3] = '["'.$tag_data_array3.'"]';
    $data[4] = '["'.$tag_data_array4.'"]';
    $data[5] = '["'.$tag_data_array5.'"]';
    $data[6] = '["'.$tag_data_array6.'"]';

    
   // $data2 = '["'.$tag_data_array2.'"]';
  
        $var[$variaveis[0]] = $labels;
      for($i=1;$i<$alteracoes;$i++){
     
      $var[$variaveis[$i]] = $data[$i];
      
      }
      
// print "<br>";
 
 //print_r($var);

   
     		
    for($i=0;$i<$alteracoes;$i++){
		 
     $code = str_replace($variaveis[$i],$var[$variaveis[$i]], $code);
     
    }
    
 print $code;
    
 //   $jscode .= $code;
    
    }
    
   
 return (0);
         
        
        
    
 }
 

function listarDash()
{
    
    
      $mysql = new mysql();
    
    $query = "SELECT
    ID_DASH, NAME_DASH, DESC_DASH, ID_OWNER, OWNER_ONLY, ACTIVE,
fx_usuarios.NOME
FROM
lmgava_my_app.ac_dashboard left join lmgava_my_sis.fx_usuarios on (ac_dashboard.id_owner = fx_usuarios.ID);
;";
    
     $result = $mysql->sql($query);
    
    return ($result);
    
    
}

function listarKlip(){
    
    $mysql = new mysql();
    
    $query="SELECT 
	`ac_graf_new`.`ID_GRAF`,
    `ac_graf_new`.`TYPE`,
    `ac_graf_new`.`CODE`,
    `ac_graf_new`.`COL`,
    `ac_graf_new`.`VARIABLES`,
    
    `ac_graf_new`.`SIZE_HEIGHT`,
    `ac_graf_new`.`SIZE_WIDTH`,
    `ac_graf_new`.`QUERY`,
GRAF_TITLE, GRAF_DESC, GRAF_SOURCE,

   COUNT(ID_DASH_ROW) AS DASHS
FROM `lmgava_my_sis`.`ac_graf_new`
 LEFT JOIN lmgava_my_app.ac_dash_row on (ac_graf_new.ID_GRAF = ac_dash_row.CHARTS_ID)
 group by
 `ac_graf_new`.`ID_GRAF`;";
 
    $result = $mysql->sql($query);
    
    return ($result);
 
    
}


function idDashRow($id_dash_row){
    
    
    $mysql = new mysql();
    
    $query = "SELECT
ID_DASH_ROW,
ID_DASH,
ROW_TAG,
CHART_TYPE,
CHARTS_ID,
CHART_TITLE,
CHART_SIZE

FROM
lmgava_my_app.ac_dash_row
where
ID_DASH_ROW = 23;";

   $result = $mysql->sql($busca_query);
   $line = mysqli_fetch_array($result);
    
   $dados = array();
   
   $dados["ID_DASH_ROW"] = $line["ID_DASH_ROW"];
   $dados["ID_DASH"] = $line["ID_DASH"];
   $dados["ROW_TAG"] = $line["ROW_TAG"];
   $dados["CHART_TYPE"] = $line["CHART_TYPE"];
   $dados["CHART_ID"] = $line["CHART_ID"];
   $dados["CHART_TITLE"] = $line["CHART_TITLE"];
   $dados["CHART_SIZE"] = $line["CHART_SIZE"];
    

return ($dados);

}

function printDashSelect($id,$selected){
    
     
    $mysql = new mysql();
    
    $query="SELECT
ID_DASH_ROW,
CHART_TITLE,
CHART_TYPE,
CHARTS_ID,
ROW_TAG,
ifnull(CONCAT('ID',CHARTS_ID,'' ,CHART_TITLE,' - ',CHART_TYPE),'Empty') AS TAG
 FROM lmgava_my_app.ac_dash_row
 WHERE
 ID_DASH = '$id';";
 
    $result = $mysql->sql($busca_query);
   
   
   $line = mysqli_fetch_array($result);
   
   $tag_select = "";
  
  $campo = $line["TAG"];
  $id_dash_row = $line["ID_DASH_ROW"];
    
    if($selected==$line["ID_DASH_ROW"]) { $tag_selected = "Selected"; } else { $tag_selected=""; }
    
            $tag.='<option '.$tag_selected .' value="'.$campo.'">'.$campo.'</option>';
    
     
                                               
    return ($tag);      
 
}  

function printDashCharts($id_dash){
    
     
    $mysql = new mysql();
    
    $query="SELECT

ID_GRAF, TYPE, CODE, COL, VARIABLES, SIZE_WIDTH, SIZE_HEIGHT, QUERY, GRAF_TITLE, GRAF_DESC, GRAF_SOURCE,
(SELECT ID_DASH FROM lmgava_my_app.ac_dash_row where CHARTS_ID = TAB1.ID_GRAF AND ID_DASH = '$id_dash') AS IN_DASH

FROM
	lmgava_my_sis.ac_graf_new AS TAB1;";
 
    $result = $mysql->sql($query);
   
      $tag="";
   
   while($line = mysqli_fetch_array($result)){
	   
       //$link = "window.open('int_adm_myreport_details.php?id_rel=".$line["ID_GRAF"]."','Janela','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=yes,width=800,height=600,left=10,top=1-'); return false;";
	   
       $id_graf = $line["ID_GRAF"];

       $link = "int_adm_dash_conf.php?act=input&id_dash=".$id_dash."&id_graf=".$id_graf;
       
       
	
   if($line["IN_DASH"]>0){ 
 
        $tag_input = '<a href="'.$link.'"><i data-feather="toggle-right" class="icon-dual-success icons-s "></i></a>';
       // $tag_input = '<a href="?" onClick="'.$link.'" ><i data-feather="toggle-right" class="icon-dual-success icons-s "></i></a>';
      
        
    }else{ 
         $tag_input = '<a href="'.$link.'"><i data-feather="toggle-right" class="icon-dual icons-s "></i></a>';
        //    $tag_input = '<a href="#" onClick="'.$link.'" ><i data-feather="toggle-right" class="icon-dual icons-s "></i></a>';
        
        
            $query_set="SELECT `ac_dash_row`.`ID_DASH_ROW`,
    `ac_dash_row`.`ID_DASH`,
    `ac_dash_row`.`ROW_NUMBER`,
    `ac_dash_row`.`ROW_TAG`,
    `ac_dash_row`.`CHART_TYPE`,
    `ac_dash_row`.`CHARTS_ID`,
    `ac_dash_row`.`CHART_TITLE`,
    `ac_dash_row`.`CHART_SIZE`,
    concat('Row ',ROW_NUMBER,' - P ',ID_DASH_ROW) AS TAG
FROM `lmgava_my_app`.`ac_dash_row`
where
ID_DASH = '$id_dash'";
 
    $result_set = $mysql->sql($query_set);
    
          $tag_input = '            <div class="dropdown">
                                                        <button class="btn btn-light btn-sm  dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            Dropdown button <i class="mdi mdi-chevron-down"></i>
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">';
                                                        
                                                          while($line_set = mysqli_fetch_array($result_set)){
                                                           
                                                           $id = $line_set["ID_DASH_ROW"];
                                                           $tag_input .= '<a class="dropdown-item" href="?act=input&id_dash_row='.$id.'&id_graf='.$id_graf .'">'.$id .'</a>';
                                                            
                                                            }
                                                        
                                                 
                                                       $tag_input .= '</div>
														</div>';
   }

 
     
    $tag .= '<tr>
        <td>'.$line["ID_GRAF"].'</td>
         <td>'.$line["TYPE"].'</td>
          <td>'.$line["GRAF_TITLE"].'</td>
           <td>'.$line["GRAF_DESC"].'</td>
            <td>'.$line["GRAF_SOURCE"].'</td>
             <td>'.$tag_input.'</td></tr>';       
        
        
    
   }
   
                                        
    return ($tag);      
       
  
} 





function insertKlip($type,$code,$variables,$query_chart,$chart_desc,$chart_title,$chart_source,$chart_size_width,$chart_size_height){
    
     $mysql = new mysql;
    //$query = base64_encode($article_code);
    
   $query = "INSERT INTO 
    `lmgava_my_sis`.`ac_graf_new`
    (`TYPE`,
    `CODE`,
    `VARIABLES`,
        `query`,
    `GRAF_DESC`,
    `GRAF_TITLE`,
    `GRAF_SOURCE`,
    `SIZE_WIDTH`,
    `SIZE_HEIGHT`
    
    )
VALUES
    ('$type',
    '$code',
    '$variables',
    '$query_chart',
    '$chart_desc',
    '$chart_title',
    '$chart_source',
    '$chart_size_width',
    '$chart_size_height');";
    
$result = $mysql->sql($query);

}

function delKlip($id){
    
    
    $mysql = new mysql;
    
    $query = "DELETE FROM `lmgava_my_sis`.`ac_graf_new`
WHERE 
ID_GRAF = '$id';";

    $result = $mysql->sql($query);
    
    
}

function editKlip($id){

    $mysql = new mysql();
    
    $query = "SELECT
ID_GRAF, TYPE, CODE, COL, VARIABLES,     `SIZE_HEIGHT`,
    `SIZE_WIDTH`, QUERY, GRAF_TITLE, GRAF_DESC, GRAF_SOURCE
FROM
lmgava_my_sis.ac_graf_new
where
ID_GRAF = '$id';";
    
    
            $result = $mysql->sql($query);
    
    $tag ="";
    
    	$line = mysqli_fetch_array($result);
    	   
           $tag.= ' data-id="'.$line["ID_GRAF"].'" ';
           $tag.= ' data-type="'.$line["TYPE"].'" ';
           $tag.= ' data-query="'.$line["QUERY"].'" ';
           $tag.= ' data-variables="'.$line["VARIABLES"].'" ';
           $tag.= ' data-code="'.htmlspecialchars($line["CODE"]).'" ';
           $tag.= ' data-graf_title="'.$line["GRAF_TITLE"].'" ';
           $tag.= ' data-graf_source="'.$line["GRAF_SOURCE"].'" ';
           $tag.= ' data-graf_desc="'.$line["GRAF_DESC"].'" ';
           $tag.= ' data-size_height="'.$line["SIZE_HEIGHT"].'" ';
           $tag.= ' data-size_width="'.$line["SIZE_WIDTH"].'" ';
           
           return($tag);
           
    
    
}

function updateKlip($chart_id,$type,$code,$variables,$query_chart,$chart_desc,$chart_title,$chart_source,$chart_size_width,$chart_size_height){
    
    $code = addslashes($code);
    
          $mysql = new mysql();
        
    $query = "UPDATE `lmgava_my_sis`.`ac_graf_new`
                SET
                `TYPE` = '$type',
                `CODE` = '$code',
                `VARIABLES` = '$variables',
                `QUERY` = '$query_chart',
                `GRAF_TITLE` = '$chart_title',
                `GRAF_DESC` = '$chart_desc',
                `GRAF_SOURCE` = '$chart_source',
                `SIZE_HEIGHT` = '$chart_size_height',
                `SIZE_WIDTH` = '$chart_size_width'                
                WHERE 
                    `ID_GRAF` = '$chart_id';";

          $result = $mysql->sql($query);

}

}



?>