<?php


	
	function myAutoload($class) 
 {
 require_once("../classes/".$class.".class.php");
 }

 spl_autoload_register('myAutoload');

$id = $_GET["id_chart"];

$chart = new mychart;

$inf = $chart->execChart($id);

print_r($inf);

if($inf["tipo"]=='PIE'){ 
        $chart->chartPie($inf);    
}elseif($inf["tipo"]=='COL'){
        $chart->chartCol($inf);    
}



?>