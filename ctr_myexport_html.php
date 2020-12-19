<?php

$id  = $_GET["ID_REL"];

$arquivo = 'export.xls';
/*
* Criando e exportando planilhas do Excel
* /
*/
// Definimos o nome do arquivo que será exportado
// Configurações header para forçar o download


function __autoload($class){
	require_once("../classes/".$class.".class.php");
}

$myexport = new myexport;

$html = $myexport->export_excel_html($id);



echo $html;
exit;