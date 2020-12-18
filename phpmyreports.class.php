
<?php
//@include "./../funcoes_fat.php";
/*************************************************************************************
*                                       ATEN��O
*  Esta classe foi desenvolvida em carater experimetal a 1 ano, nao recomendo utilizacao
*  em ambiente de trabalho, estou desenvolvendo uma versao estavel com mais recursos
*  esta e uma previa, estou recebendo sugestoes no breno@sipvox.com.br
**************************************************************************************
*      Classe:  phpMyform
*   Descri��o:  v0.1 Classe utilizada para gerar relar�rios din�micos a partir de uma
*                string SQL simples.
*   Em Breve...
*       - Remodelagem para aproveitar POO do PHP 5
*       - Pagina��o de resultados
*       - Mais op��es de skins
*       - Abstra��o da base de dados
*       - Totaliza��o de campos (formulas)
*       - Manipula��o dos resultados p�s-select
*       - Sugest�es: breno@sipvox.com.br
*
Exemplo:
 
include_once('phpmyreports.class.php');
$teste = new phpmyreports();
$teste->conectar('localhost','usuario','senha','banco_de_cados');
$teste->query("SELECT * FROM `tabela`");
$teste->tbl_title = 'T�tulo do relat�rio';
$teste->skin = 'silver'; // Skin a ser utilizada: padr�o silver
$teste->campos = 'campo1,campo2,campo3';
$teste->labels = 'T�tulo C1,T�tulo C2,T�tulo C3';
$teste->fonte = 'www.site.com'; // Descreva a fonte dos dados, use '' para nenhuma
$teste->parse();
 
*************************************************************************************/
 
if (!class_exists('phpmyreports')){
    class phpmyreports {
        var $servidor, $user, $senha;
        var $banco, $tabela, $campos,$labels;
        var $link_,$query;
        var $tbl_title,$skin;
		var $estilo;
        var $fields = array();
		
					
					

       
        function erro($ttl,$str){
            echo '<table width="100%"  border="0" cellpadding="3" cellspacing="0" bgcolor="#CCCCCC" style="border:1px solid #000000"><tr><td><span style="font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 10px;font-weight: bold;color: #FF0000;"> phpMyReports - '.$ttl.'</span></td></tr><tr><td valign="middle"><span style="color: #000000;font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 9px;">'.$str.'</span></td></tr></table><br>';
        }
        // Fun��o de conex�o ao banco de dados
        function conectar($server,$user,$senha,$banco){
            $this->link_ = mysql_connect($server,$user,$senha) or die('Erro...');
            $this->banco = mysql_select_db($banco,$this->link_);
        }
       
        // Fun��o de de query ao banco de dados
        function query($sql){
            $this->query = mysql_query($sql,$this->link_) or die($this->erro('String SQL','Erro encontrado na sua query SQL, favor verifique seu c�digo:<br><br><strong>'.$sql.'</strong><br><br>'.mysql_error()));
        }
       
        // Fun��o de query com retorno
        function query2($sql){
            return mysql_query($sql,$this->link_) or die($this->erro('String SQL','Erro encontrado na sua query SQL, favor verifique seu c�digo:<br><br><strong>'.$sql.'</strong><br><br>'.mysql_error()));
        }      
        // Fun��o que gera a primeira linha da tabela
        function gera_labels(){
            echo "\n<tr>";
            $labels = explode(',',$this->labels);
            foreach($labels as $label){
                $var_label .=  '<td class="silver_td_caption">'.$label.'</td>';
            }
            $var_label .= "</tr>\n";
			
			return ($var_label);
        }
       
        // Fun��o que exibe os dados da conex�o
        function gera_listagem(){
            $ln = 2;
            $campos = explode(',',$this->campos);      
            while($dados = mysql_fetch_object($this->query)){
                if ($ln == 2){ $ln = 1; } else { $ln = 2; }
                $var_listagem .= "\n".'<tr class="'.$this->skin.'_tr_list_row'.$ln.'" onmouseover="this.className=\'silver_tr_list_row_over\';return true" onmouseout="this.className=\''.$this->skin.'_tr_list_row'.$ln.'\';return true">';
                foreach($campos as $campo){
                
                    $var_listagem .= '<td>'.strip_tags($dados->$campo,'<b><i><u><a>').'</td>';
                }
                $var_listagem .= "</tr>\n";
            }
			return ($var_listagem);
        }
       
        // Fun��o que exibe as bases e o fim do site
        function finaliza(){
            $var_final .= '</table></td></tr><tr><td class="silver_td_last_row">';
            if (isset($this->fonte)){ $var_final .= 'Fonte: '.$this->fonte; } else { $var_final .= '&nbsp;'; }
            $var_final .= '</td></tr></table></td></tr></table>';
			
			return ($var_final);
			
        }
       
        // Fun��o de escrita
        function parse(){
            if ($this->skin == ''){ $this->skin = 'silver'; }
            if ($this->labels == ''){ $this->labels = $this->campos; }
            if ($this->tbl_title == ''){ $this->tbl_title = 'T�tulo N�o Informado'; }
            if ($this->campos == ''){ $this->erro('Campos para Exibi��o','Campos para exibi��o n�o informados, favor verifique seu c�digo. <br>Modelo:<br><pre style="font-size:12px;">$myform->campos = "campo1,campo2,campoN";</pre>'); }
            $campos = count(explode(',',$this->campos));
            $labels = count(explode(',',$this->labels));           
            if ($campos != $labels){ $this->erro('Campos x Labels','O n�mero de labels � diferente do n�mero de campos, favor verifique seu c�digo.<br><br>Campos: '.$campos.' - '.$this->campos.'<br>Labels: '.$labels.' - '.$this->labels.''); }
            else {
                $var  = '<style>body,td,th {  font-family: Verdana, Arial, Helvetica, sans-serif;     font-size: 9px;     cursor:default; }';
				$var .='.silver_tbl_main {     border: 1px solid E5E5E5;     background-color:F9F9F9; }'; 
				$var .='.silver_td_title {     font-size: 13px;     font-weight: bold;     color: 7B7B7B;     text-decoration: none;     padding:5px; }';
				$var .='.silver_td_caption {    padding:5px;    background-color: 7B7B7B;       color: FFFFFF;    font-size: 10px;    font-weight: bold;    text-align: center;    vertical-align: middle; }';
				$var .='.silver_td {    padding:5px;    font-family: Verdana;    background-color: 7B7B7B;       color: FFFFFF;    font-size: 10px;    text-align: center;    vertical-align: middle;}';
				$var .='.silver_td_caption2 {     padding:3px;    background-color: 7B7B7B;       color: FFFFFF;    font-size: 10px;    font-weight: bold;    vertical-align: middle;}';
				$var .='.silver_td_content {    color: 7B7B7B;    padding:5px;    vertical-align:top; }';
				$var .='.silver_td_last_row {    background-color:7b7b7b;    text-decoration:bold;    text-align:left;    padding:2px;    color:CCCCCC;}';
				$var .='.silver_td_last_row2 {    background-color:CCCCCC;    text-decoration:bold;    text-align:left;    padding:2px;    color:CCCCCC;}';
				$var .='.silver_tr_list_row1 {    background-color:EEEEEE;    text-decoration:none;    text-align:left;}';
				$var .='.silver_tr_list_row2 {    background-color:F8F8F8;    text-decoration:none;    text-align:left;}';
				$var .='.silver_tr_list_row_over {    background-color:CCCCCC;    text-decoration:none;    text-align:left;}';

				
				
				$var .='</style>';
                $var .= '<table width="100%"  border="0" cellspacing="0" class="silver_tbl_main"><tr><td class="silver_td_title">'.$this->tbl_title.'</td></tr><tr><td align="center" valign="top" class="silver_td_content"><table width="100%"  border="0" cellspacing="0" cellpadding="0"><tr><td align="center" valign="top"><table width="100%"  border="0" cellpadding="3" cellspacing="1">'."\n";
                $var .= $this->gera_labels();
                $var .= $this->gera_listagem();
                $var .= $this->finaliza(); 
            }
			return ($var);
        }
    
		//Retorna em Variavel
		
	
	
	}
}
 
 
 
?>