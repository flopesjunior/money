<?
require_once('../../../indicadores.ini.php');

    $ftt_can_email   = $_POST["ftt_can_email"];
    
    $sSql = "
        select 	
        ftt_can_id, 
        ftt_can_nome, 
        ftt_can_email, 
        ftt_can_celular, 
        ftt_can_endereco, 
	ftt_can_cidade, 
	ftt_can_uf, 
	ftt_can_telefone, 
	ftt_can_instuicao_ensino, 
	ftt_can_curso, 
	ftt_can_escolaridade, 
	ftt_can_id_departamento
	from 
	ftt_candidato
        where ftt_can_email = '$ftt_can_email'
        ";  
//                                    echo $sSql."<BR>";

        $SqlResult_1 = $dbsis_mysql->Execute($sSql) or die("ERRx001:serial_Listen");    

        $sHtml = "";
        
        if ($SqlResult_1->NumRows() > 0) {    
           $ftt_can_nome  = $SqlResult_1->fields["ftt_can_nome"];
           $ftt_can_id    = $SqlResult_1->fields["ftt_can_id"];
                    
           $sDisplay = "true|$ftt_can_nome|$ftt_can_id";
        }
        else {
           $sDisplay = "false"; 
        }
    
        echo $sDisplay;
        
        
    
?>