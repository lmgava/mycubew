<?php
class cron{

function cron(){

return 1;
}
	
function exec_rel($id_cron,$rel,$ext){
//primeira etapa gerar relatorio HTML


$mysql = new mysql();
 
 
$query = "SELECT
			query,
			campos,
			labels,
			fonte,
			title
			FROM ac_export
		WHERE
			id_relatorio = $rel;";

$result = $mysql->sql($query); 
  
$line_rel = mysql_fetch_array($result);


$query_cron = "SELECT
				DESTINATARIO,
				ASSUNTO,
				DESCRICAO_EMAIL,
				NOME_ARQUIVO,
                ARQUIVO
			FROM ac_cron
		WHERE
			ID_CRON = $id_cron;";

$result_cron = $mysql->sql($query_cron); 
  
$line_cron = mysql_fetch_array($result_cron);

 $destinatario  = $line_cron["DESTINATARIO"];
 $assunto       = $line_cron["ASSUNTO"];
 $mensagem      = $line_cron["DESCRICAO_EMAIL"];
 $nome_arquivo  = $line_cron["NOME_ARQUIVO"];
 $arquivo       = $line_cron["ARQUIVO"];


$query  = $line_rel["query"];
$campos = $line_rel["campos"];
$labels = $line_rel["labels"];
$title  = $line_rel["title"];
$fonte  = $line_rel["fonte"];


$teste = new phpmyreports();
$teste->conectar('localhost','lmgava_mycube','Luasol1020','lmgava_my_app');
$teste->query($query);
$teste->tbl_title = $title;
$teste->skin = 'silver'; // Skin a ser utilizada: padrão silver
$teste->campos = $campos;
$teste->labels = $labels;
$teste->fonte = $fonte; // Descreva a fonte dos dados, use '' para nenhuma
//$teste->parse();
$texto = $teste->parse();
 

if($arquivo==1){ 

# Nome do arquivo html
$arquivo = $nome_arquivo.".".$ext;

#Criar o arquivo
$fp = fopen($arquivo , "w");
$fw = fwrite($fp, $texto);

#Verificar se o arquivo foi salvo.
if($fw == strlen($texto)) {
   //echo 'Arquivo criado com sucesso!! <a href="'.$arquivo.'">'.$arquivo.'</a>';
   
   
set_time_limit(0);

	$arquivo_size = filesize($arquivo);

    // Abre o arquivo para codificá-lo no formato de email
    $file           = fopen($arquivo, "r");
    $contents       = fread($file, $arquivo_size);
    $encoded_attach = chunk_split(base64_encode($contents));
    fclose($file);  
   
    // Define os headers do anexo e da mensagem
    $mailheaders .= "MIME-version: 1.0\n";
    $mailheaders .= "Content-type: multipart/mixed; ";
    $mailheaders .= "boundary=\"Message-Boundary\"\n";
    $mailheaders .= "Content-transfer-encoding: 7BIT\n";
    $mailheaders .= "X-attachments: $arquivo";

    $body_top = "--Message-Boundary\n";
    $body_top .= "Content-type: text/plain; charset=iso-8859-1\n";
    $body_top .= "Content-transfer-encoding: 7BIT\n";
    $body_top .= "Content-description: Mail message body\n\n";

    $msg_body = $body_top . $mensagem;

    $msg_body .= "\n\n--Message-Boundary\n";
    $msg_body .= "Content-type: text/xml; name=\"$arquivo\"\n";
    $msg_body .= "Content-Transfer-Encoding: BASE64\n";	
    $msg_body .= "Content-disposition: attachment; filename=\"$arquivo\"\n\n";
	$header .= "From: cron@mycube.com.br\n";
    $msg_body .= "$encoded_attach\n";
    $msg_body .= "--Message-Boundary--\n";

    /**
     * @ Informações
     * Faça a conexão
     * Selecione o banco de dados
     */
        mail($destinatario, $assunto, $msg_body, $mailheaders);
   //print $msg_body;
   
    }else{
   echo 'falha ao criar arquivo';
	}
    
 }else{
    
   
set_time_limit(0);

  
    // Define os headers do anexo e da mensagem
    $mailheaders .= "MIME-version: 1.0\n";
    $mailheaders .= "Content-type: multipart/mixed; ";
    $mailheaders .= "From: cron@mycube.com.br\n";
    $mailheaders .= "Content-type: text/html; charset=iso-8859-1\r\n";
    
    $headers = "Content-Type:text/html; charset=UTF-8\n";
    $headers .= "From: dominio.com.br<sistema@dominio.com.br>\n"; //Vai ser //mostrado que o email partiu deste email e seguido do nome 
    $headers .= "X-Sender: <cron@mycube.com.br>\n"; //email do servidor //que enviou
    $headers .= "MIME-Version: 1.0\n"; 
    $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";



    $msg_body = $body_top.$mensagem.$texto;
    /**
     * @ Informações
     * Faça a conexão
     * Selecione o banco de dados
     */
        mail($destinatario, $assunto, $msg_body, $headers);
    
    }

}

function verifica_id(){
 
 $sql = new mysql(); 
 
 
 
$data =date("d/m/Y");
$h = date("H");
$m = date("i");
//echo $data."-".$h.":".$m."<br>";


$result_cel = (ceil($m/15)-1)*15;

	$query = "SELECT
				`fx_intervalos`.`ID_HORARIO`,
				`fx_intervalos`.`INTERVALO_15`,
				DATE_FORMAT(`fx_intervalos`.`INTERVALO_15`,'%H') AS HORA,
				DATE_FORMAT(`fx_intervalos`.`INTERVALO_15`,'%i') AS MIN
		FROM
				`fx_intervalos`
		WHERE
			DATE_FORMAT(`fx_intervalos`.`INTERVALO_15`,'%H') = '$h'
		AND
			DATE_FORMAT(`fx_intervalos`.`INTERVALO_15`,'%i') like '%$result_cel';";

$result = $sql->sql($query); 
  
$line = mysql_fetch_array($result);

$id_horario =  $line["ID_HORARIO"];

return ($id_horario);

}

function exec_cron($id_horario){

$mysql = new mysql();
 
 
 $dia = date("j");
 $semana = date("N");
 $mes = date("n");
 
 
$query = "SELECT
        ID_CRON,				
        ID_REL,
		ARQUIVO,
		EXT
		FROM
			ac_cron
			WHERE
            ((ID_HORARIO = '-1' OR ID_HORARIO = '$id_horario') AND
			(DIA_DIA = '-1' OR DIA_DIA = '$dia')  AND
            (DIA_SEMANA = '-1' OR DIA_SEMANA = '$semana')  AND
            (DIA_MES = '-1' OR DIA_MES = '$mes'))
            AND ATIVO = '1';";
			

$result = $mysql->sql($query); 
  
return ($result);
}


function listaCron(){

$mysql = new mysql();

$query = "SELECT 
				ac_cron.ID_CRON,
                ac_cron.NOME_AGENDAMENTO,
				ac_cron.ID_HORARIO, 
				fx_intervalos.INTERVALO_15, 
				ID_REL as ID_RELATORIO, 
				DIA_MES, 
				DIA_SEMANA, 
				DIA_DIA, 
				ac_cron.ATIVO,  
				`DESTINATARIO` , 
				`ASSUNTO` ,  
				`DESCRICAO_EMAIL` , 
				`ARQUIVO` ,  
				`EXT` ,  
				`NOME_ARQUIVO` , 
				ac_export.title, 
				ac_export.RELATORIO, 
				ac_export.RESPONSAVEL
		FROM ac_cron
				LEFT JOIN fx_intervalos ON ( ac_cron.ID_HORARIO = fx_intervalos.ID_HORARIO ) 
				LEFT JOIN ac_export ON ( ac_cron.ID_REL = ac_export.ID_RELATORIO );";
	
	$result = $mysql->sql($query);
		
	return($result);

}

function listaIntervalo(){

$mysql = new mysql();

$query = "SELECT
			ID_HORARIO,
			INTERVALO_15
		FROM
			fx_intervalos;";


$result = $mysql->sql($query);
		
	return($result);

}
	
function incluirCron($id_horario,$nome_agendamento,$id_rel,$dia_mes,$dia_semana,$dia_dia,$ativo,$destinatario,$assunto,$descricao_email,$arquivo,$ext,$nome_arquivo){

$mysql = new mysql();

$query = "INSERT INTO `ac_cron`
(`ID_HORARIO`,NOME_AGENDAMENTO,`ID_REL`,`DIA_MES`,`DIA_SEMANA`,`DIA_DIA`,`ATIVO`,`DESTINATARIO`,`ASSUNTO`,`DESCRICAO_EMAIL`,`ARQUIVO`,`EXT`,`NOME_ARQUIVO`)
VALUES
	('$id_horario','$nome_agendamento','$id_rel','$dia_mes','$dia_semana','$dia_dia','$ativo','$destinatario','$assunto','$descricao_email','$arquivo','$ext','$nome_arquivo');";

$result = $mysql->sql($query);

return (true);
}

function alterarCron($id_cron,$id_horario,$nome_agendamento,$id_rel,$dia_mes,$dia_semana,$dia_dia,$ativo,$destinatario,$assunto,$descricao_email,$arquivo,$ext,$nome_arquivo){

$mysql = new mysql();

$query = "UPDATE `ac_cron`
            SET 
        
        ID_HORARIO          = '$id_horario',
        NOME_AGENDAMENTO    = '$nome_agendamento',
        ID_REL              = '$id_rel',
        DIA_MES             = '$dia_mes',
        DIA_SEMANA          = '$dia_semana',
        DIA_DIA             = '$dia_dia',
        ATIVO               = '$ativo',
        DESTINATARIO        = '$destinatario',
        ASSUNTO             = '$assunto',
        DESCRICAO_EMAIL     = '$descricao_email',
        ARQUIVO             = '$arquivo',    
        EXT                 = '$ext',
        NOME_ARQUIVO        = '$nome_arquivo'
                WHERE   
ID_CRON = '$id_cron';";

$result = $mysql->sql($query);

return ($result);
}

function excluirCron($id_cron){
    
    $mysql = new mysql();
    
  $query = "DELETE FROM `ac_cron`
    WHERE ID_CRON = '$id_cron';";

$result = $mysql->sql($query);

return (true);
}



function dadosCron($id){

$mysql = new mysql();

$query = "SELECT 
                ac_cron.NOME_AGENDAMENTO,
				ac_cron.ID_CRON,
				ac_cron.ID_HORARIO, 
				fx_intervalos.INTERVALO_15, 
				ID_REL, 
				DIA_MES, 
				DIA_SEMANA, 
				DIA_DIA, 
				ac_cron.ATIVO,  
				`DESTINATARIO` , 
				`ASSUNTO` ,  
				`DESCRICAO_EMAIL` , 
				`ARQUIVO` ,  
				`EXT` ,  
				`NOME_ARQUIVO` , 
				ac_export.title, 
				ac_export.RELATORIO, 
				ac_export.RESPONSAVEL
		FROM ac_cron
				LEFT JOIN fx_intervalos ON ( ac_cron.ID_HORARIO = fx_intervalos.ID_HORARIO ) 
				LEFT JOIN ac_export ON ( ac_cron.ID_REL = ac_export.ID_RELATORIO )
    where
    ID_CRON = '$id';";
	
	$result = $mysql->sql($query);
		
	return($result);

}




}
	
?>