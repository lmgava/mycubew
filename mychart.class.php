<?php


/**
 * mychart
 * 
 * @package Mycubew
 * @author Gava Leonardo
 * @copyright 2020
 * @version $Id$
 * @access public
] */

class mychart{
    
    

/**
 * mychart::incluirChart()
 * 
 * @param mixed $dados
 * @return
 */
 
function incluirChart($dados){

    
    $mysql = new mysql();
    
    $query="INSERT INTO `ac_graf`
(`TIPO`,`EIXOX`,`ROTULO_CAMPO`,`ROTULO_VALOR`,`NUMSERIES`,`SERIES`,`TITULO`,`LEGENDA`,`FONTE`,
`QUERY`,`ATIVO`,`RELATORIO`,`RESPONSAVEL`)
VALUES
('$dados[tipo]',
 '$dados[eixox]',
 '$dados[rotulo_campo]',
 '$dados[rotulo_valor]',
 '$dados[numseries]',
 '$dados[series]',
 '$dados[titulo]',
 '$dados[legenda]',
 '$dados[fonte]',
 '$dados[query]',
 '$dados[ativo]',
 '$dados[relatorio]',
 '$dados[responsavel]');";
 
 $result = $mysql->sql($query);
 
 return 1;    
    
}

function dadosChart($id){
    
    $mysql = new mysql();
    
    $query = "SELECT
                `ac_graf`.`ID_GRAF`,
                `ac_graf`.`TIPO`,
                `ac_graf`.`EIXOX`,
                `ac_graf`.`ROTULO_CAMPO`,
                `ac_graf`.`ROTULO_VALOR`,
                `ac_graf`.`NUMSERIES`,
                `ac_graf`.`SERIES`,
                `ac_graf`.`TITULO`,
                `ac_graf`.`LEGENDA`,
                `ac_graf`.`FONTE`,
                `ac_graf`.`QUERY`,
                `ac_graf`.`ATIVO`,
                `ac_graf`.`RELATORIO`,
                `ac_graf`.`RESPONSAVEL`
                FROM `ac_graf`
            WHERE
                ID_GRAF = '$id';";

        $result = $mysql->sql($query);
        
        $line = mysqli_fetch_array($result, MYSQL_BOTH);
         
$dados["id_graf"]      = $line["id_graf"];
$dados["query"]	     = $line["QUERY"];
$dados["campos"]	 	 = $line["CAMPOS"];
$dados["fonte"] 	     = $line["FONTE"];
$dados["titulo"]		 = $line["TITULO"];
$dados["relatorio"]	 = $line["RELATORIO"];
$dados["responsavel"]	 = $line["RESPONSAVEL"];
$dados["tipo"]	 	 = $line["TIPO"];
$dados["eixox"]	 	 = $line["EIXOX"];
$dados["rotulo_campo"] = $line["ROTULO_CAMPO"];
$dados["rotulo_valor"] = $line["ROTULO_VALOR"];
$dados["numseries"]    = $line["NUMSERIES"];
$dados["series"]       = $line["SERIES"];




if($line["ATIVO"]==1)
		{ $dados["ativo"]='Checked';}
	else{$dados["ativo"]='';}
    
    return ($dados);
    
}

function editarChart($dados){

    $mysql = new mysql();
    
    $query="UPDATE `ac_graf`
                        SET                    
                    `TIPO`          = '$dados[tipo]',
                    `EIXOX`         = '$dados[eixox]',
                    `ROTULO_CAMPO`  = '$dados[rotulo_campo]',
                    `ROTULO_VALOR`  = '$dados[rotulo_valor]',
                    `NUMSERIES`     = '$dados[numseries]',
                    `SERIES`        = '$dados[series]',
                    `TITULO`        = '$dados[titulo]',
                    `LEGENDA`       = '$dados[legenda]',
                    `FONTE`         = '$dados[fonte]',
                    `QUERY`         = '$dados[query]',
                    `ATIVO`         = '$dados[ativo]',
                    `RELATORIO`     = '$dados[relatorio]',
                    `RESPONSAVEL`   = '$dados[responsavel]'
                    WHERE
                          `ID_GRAF` = '$dados[id_graf]';";
    
    $result = $mysql->sql($query);
 
 return 1;

    
}

function excluirChart($dados){
    
    $mysql = new mysql();
    
    $query = "DELETE FROM 
                `ac_graf`
            WHERE
            ID_GRAF = '$dados[id_graf]'';";
    $result = $mysql->sql($query);
 
 return 1;
    
}


function listarCharts(){
    
    $mysql = new mysql();
    
    $query = "SELECT
               `ac_graf`.`ID_GRAF`,
                `ac_graf`.`TIPO`,
                `ac_graf`.`EIXOX`,
                `ac_graf`.`ROTULO_CAMPO`,
                `ac_graf`.`ROTULO_VALOR`,
                `ac_graf`.`NUMSERIES`,
                `ac_graf`.`SERIES`,
                `ac_graf`.`TITULO`,
                `ac_graf`.`LEGENDA`,
                `ac_graf`.`FONTE`,
                `ac_graf`.`QUERY`,
                `ac_graf`.`ATIVO`,
                `ac_graf`.`RELATORIO`,
                `ac_graf`.`RESPONSAVEL`
                FROM `ac_graf`;";
    
     $result = $mysql->sql($query);
    
    return ($result);
}

function execChart($id_graph){
    
    $mysql = new mysql();
    
    $busca_query = "SELECT 
                    QUERY,
                    TIPO,
                    ROTULO_CAMPO,
                    ROTULO_VALOR,
                    ID_GRAF, 
                    EIXOX, 
                    NUMSERIES, 
                    SERIES, 
                    TITULO, 
                    LEGENDA, 
                    FONTE
                    FROM `ac_graf`
            WHERE
                    ID_GRAF = '$id_graph';";
    
    $result = $mysql->sql($busca_query);
    
        
    $line = mysqli_fetch_array($result);
    
    
     
$inf["eixoX"]     = $line["EIXOX"];
$inf["numSeries"] = $line["NUMSERIES"];
$inf["Series"]    = explode(',', $line["SERIES"]);
$inf["titulo"]    = $line["TITULO"];
$inf["fonte"]     = $line["FONTE"];
$inf["query"]     = $line["QUERY"];
$inf["rotulo_campo"]= $line["ROTULO_CAMPO"];
$inf["rotulo_valor"]= $line["ROTULO_VALOR"];
$inf["tipo"]= $line["TIPO"];

    
      
return ($inf);
    
}

function chartCol($inf){
    
    
            //the usual stuff 
            $con = mysqli_connect("localhost","phpuser","Luasol1020","lmgava_my_app","3308");
            if (!$con) {   die('Could not connect: ' . mysql_error()); }
            mysqli_select_db( $con, "lmgava_my_rel");

            $sql = mysqli_query($con, $inf["query"]);

            $data = array();
            $data2 = array();
            
            
            while ($row = mysqli_fetch_array($sql)) {
               
                 $dados["eixoX"][] = "'".$row[$inf["eixoX"]]."'";
                
                 for($i=0;$i<$inf["numSeries"];$i++){
                        $dados["Series"][$i][] = $row[$inf["Series"][$i]];
                        
                        //echo $inf[Series][$i]."<br>";
                 }        
  
            }
            
            mysqli_close($con);
            
            
            
        ?>

        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
        <script type="text/javascript">
            $(function () {
                var chart;
                $(document).ready(function() {
                    chart = new Highcharts.Chart({
                        chart: {
                            renderTo: 'container',
                            type: 'column',
                            marginRight: 0,
                            marginBottom: 25
                        },
                        title: {
                            text: <?php echo "'".$inf["titulo"]."'"; ?>,
                            x: -20 //center
                        },
                        subtitle: {
                            text: <?php echo "'".$inf["fonte"]."'" ?>,
                            x: -20
                        },
                        xAxis: {
                            categories:[<?php echo join($dados["eixoX"], ',') ?>]
  
                        },
                        
                        yAxis: {
                            title: {
                                text: <?php echo "'".$inf["titulo"]."'" ?>
                            },
                            min: 0
                        },
                        tooltip: {
                            formatter: function() {
                                    return '<b>'+ this.series.name +'</b><br/>'+
                                    this.x +': '+ this.y;
                            }
                        },
                        legend: {
                            layout: 'horizontal',
                            align: 'center',
                            verticalAlign: 'top',
                            x: -10,
                            y: 100,
                            borderWidth: 0
                        },
                        series: [ 
                            
                           <?php
                           
                           
                           if($inf["numSeries"]==1) {  ?> 
                                            {
                                                name: '<?php echo $inf["Series"][0] ?>',
                                                data:  [<?php echo join($dados["Series"][0], ',') ?>]                                       
                                                } <?php }
                            elseif($inf["numSeries"]==2) { ?>
                                                {
                                                name: '<?php echo $inf["Series"][0] ?>',
                                                data:  [<?php echo join($dados["Series"][0], ',') ?>]                                       
                                                },
                                                {
                                                name: '<?php echo $inf["Series"][1] ?>',
                                                data:  [<?php echo join($dados["Series"][1], ',') ?>]                                       
                                                } <? }
                           elseif($inf["numSeries"]==3) { ?>
                                        {
                                                name: '<?php echo $inf["Series"][0] ?>',
                                                data:  [<?php echo join($dados["Series"][0], ',') ?>]                                       
                                                },
                                                {
                                                name: '<?php echo $inf["Series"][1] ?>',
                                                data:  [<?php echo join($dados["Series"][1], ',') ?>]                                       
                                                },
                                                {
                                                name: '<?php echo $inf["Series"][2] ?>',
                                                data:  [<?php echo join($dados["Series"][2], ',') ?>]                                       
                                                } <?php }
                           
                           elseif($inf["numSeries"]==4) { ?>    
                           
                                                {
                                                name: '<?php echo $inf["Series"][0] ?>',
                                                data:  [<?php echo join($dados["Series"][0], ',') ?>]                                       
                                                },
                                                {
                                                name: '<?php echo $inf["Series"][1] ?>',
                                                data:  [<?php echo join($dados["Series"][1], ',') ?>]                                       
                                                },
                                                {
                                                name: '<?php echo $inf["Series"][2] ?>',
                                                data:  [<?php echo join($dados["Series"][2], ',') ?>]                                       
                                                },
                                                {
                                                name: '<?php echo $inf["Series"][3] ?>',
                                                data:  [<?php echo join($dados["Series"][3], ',') ?>]                                       
                                                }<?php }
                           elseif($inf["numSeries"]==5) { ?> 
                                            {
                                                name: '<?php echo $inf["Series"][0] ?>',
                                                data:  [<?php echo join($dados["Series"][0], ',') ?>]                                       
                                                },
                                                {
                                                name: '<?php echo $inf["Series"][1] ?>',
                                                data:  [<?php echo join($dados["Series"][1], ',') ?>]                                       
                                                },
                                                {
                                                name: '<?php echo $inf["Series"][2] ?>',
                                                data:  [<?php echo join($dados["Series"][2], ',') ?>]                                       
                                                },
                                                {
                                                name: '<?php echo $inf["Series"][3] ?>',
                                                data:  [<?php echo join($dados["Series"][3], ',') ?>]                                       
                                                },
                                                {
                                                name: '<?php echo $inf["Series"][4] ?>',
                                                data:  [<?php echo join($dados["Series"][4], ',') ?>]                                       
                                                } <?php } 
                           elseif($inf["numSeries"]==6) { ?> 
                           
                                           {
                                                name: '<?php echo $inf["Series"][0] ?>',
                                                data:  [<?php echo join($dados["Series"][0], ',') ?>]                                       
                                                },
                                                {
                                                name: '<?php echo $inf["Series"][1] ?>',
                                                data:  [<?php echo join($dados["Series"][1], ',') ?>]                                       
                                                },
                                                {
                                                name: '<?php echo $inf["Series"][2] ?>',
                                                data:  [<?php echo join($dados["Series"][2], ',') ?>]                                       
                                                },
                                                {
                                                name: '<?php echo $inf["Series"][3] ?>',
                                                data:  [<?php echo join($dados["Series"][3], ',') ?>]                                       
                                                },
                                                {
                                                name: '<?php echo $inf["Series"][4] ?>',
                                                data:  [<?php echo join($dados["Series"][4], ',') ?>]                                       
                                                },
                                                {
                                                name: '<?php echo $inf["Series"][5] ?>',
                                                data:  [<?php echo join($dados["Series"][5], ',') ?>]                                       
                                                }   <?php } ?>  
                                                
                                                
                        ]

                    });
                });
                
            });

            </script>
   
                                <!-- Portlet card -->
                                <div class="card">
                                    <div class="card-body">
                                <?php 
                                   if(isset($_GET["act"])){
                                    
                                        echo $html->alertTag($_GET["act"]);
                                        
                                         } 
                                   
                                   ?>
                                        <div class="card-widgets">
                                            <a href="javascript: void(0);" data-toggle="reload"><i class="mdi mdi-refresh"></i></a>
                                            <a data-toggle="collapse" href="#cardCollpase1" role="button" aria-expanded="false" aria-controls="cardCollpase1"><i class="mdi mdi-minus"></i></a>
                                            <a href="javascript: void(0);" data-toggle="remove"><i class="mdi mdi-close"></i></a>
                                        </div>
                                        <h4 class="header-title mb-0">Casos</h4>

                                        <!-- content -->
                                        leo
                                        
                                       <div id="container"></div>

    
                                    </div> <!-- end card-body -->
                                </div> <!-- end card-->
               
                         

<?php
    
}
    
function chartPie($inf){
    
    $con = mysqli_connect("localhost","phpuser","Luasol1020","lmgava_my_app","3308");
            if (!$con) {   die('Could not connect: ' . mysql_error()); }
            mysqli_select_db( $con, "lmgava_my_sis");

 $sql = mysqli_query($con, $inf["query"]);

         // print $inf["query"];
                
            
            while ($row = mysqli_fetch_array($sql)) {
                
                
               
               $dados[] = "['".$row[$inf["rotulo_campo"]]."',".$row[$inf["rotulo_valor"]]."]";
                                        
  
            }
            
            mysqli_close($con);
            
             $dados = implode(",",$dados) ;
                            
               
            
        ?>

        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
        <script type="text/javascript">
        
$(function () {
    $('#container_pie').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: <?php echo "'".$inf["titulo"]."'"; ?>
        },
        subtitle: {
            text: <?php echo "'".$inf["fonte"]."'"; ?>,
            x: -20
        },

        tooltip: {
    	    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    color: '#000000',
                    connectorColor: '#000000',
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                }
            }
        },
        series: [{
            type: 'pie',
            name: '<?php echo $inf["Serie"] ?>',
            data:  [<?php echo $dados; ?>] 
        }]
    });
});
            </script>
    </head>
    <body>
<script src="../highchart/js/highcharts.js"></script>
<!-- <script src="../highchart/js/exporting.js"></script> -->

<div id="container_pie" style="min-width: 400px; height: 400px; margin: 0 "></div>

    </body>
</html>

<?php    
}
 
/* Gráfico de Linha com data */


function chartLinTime($inf){
    
    
    
    
    
    
    
    
} 

    
}

?>