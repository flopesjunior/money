<?
require_once('../../../indicadores.ini.php');

    $ftt_tst_id                 = $_POST["ftt_tst_id"];
    $ftt_tst_id_candidato       = $_POST["ftt_tst_id_candidato"];
    $ftt_tst_id_prova           = $_POST["ftt_tst_id_prova"];
    $ftt_tst_id_area            = $_POST["ftt_tst_id_area"];    
    $ftt_can_email              = $_POST["ftt_can_email"];
    $ftt_can_nome               = $_POST["ftt_can_nome"];
    $ftt_tst_id_area            = $_POST["ftt_tst_id_area"];
    
    
    
    if (!$ftt_tst_id_candidato){
        
        $sSql = "insert into ftt_candidato 
	(ftt_can_nome, ftt_can_email) values
	('$ftt_can_nome', '$ftt_can_email')";

        $dbsis_mysql->Execute($sSql) or die("ERRx001:INSERE CONDIDATO - \n ".$sSql);    
        
        //Pega o ultimo is inserido
        $sSql = "
                select ftt_can_id
                from ftt_candidato
                where ftt_can_email = '$ftt_can_email'
                ";  
        //                                    echo $sSql."<BR>";

        $SqlResult_1 = $dbsis_mysql->Execute($sSql) or die("ERRx001:serial_Listen - \n ".$sSql);    

        if ($SqlResult_1->NumRows() > 0) {
            $ftt_tst_id_candidato                     = $SqlResult_1->fields["ftt_can_id"];         
        }        
        
        
    }
    else {
            $sSql = "
                select ftt_tst_id
                from ftt_teste
                where ftt_tst_id_candidato = $ftt_tst_id_candidato and ftt_tst_status <> 4
                ";  
            
            $SqlResult_1 = $dbsis_mysql->Execute($sSql) or die("ERRx001:serial_Listen - \n ".$sSql);    

            if ($SqlResult_1->NumRows() > 0) {
                echo "existe";
                exit;
            }                
    }
    
    
    if (!$ftt_tst_id){    
        //$sSql = "DELETE FROM apu_apuracao WHERE apu_apu_id_zon = $apu_zon_id AND apu_apu_id_ses = $apu_ses_id";
        //$dbsis_mysql->Execute($sSql) or die("ERRx001:DELETA");    

        
        
        $sSql = "
                insert into ftt_teste (
                        ftt_tst_id_candidato, 
                        ftt_tst_data_cadastro, 
                        ftt_tst_id_prova, 
                        ftt_tst_id_area
                        ) values (
                        $ftt_tst_id_candidato, 
                        NOW(), 
                        $ftt_tst_id_prova, 
                        $ftt_tst_id_area
                        )            
        ";                

        $dbsis_mysql->Execute($sSql) or die("ERRx001:INSERE TESTE - \n ".$sSql);    

        //Pega o ultimo is inserido
        $sSql = "
                select max(ftt_tst_id) as ftt_tst_id
                from 
                ftt_teste
                ";  
        //                                    echo $sSql."<BR>";

        $SqlResult_1 = $dbsis_mysql->Execute($sSql) or die("ERRx001:serial_Listen - \n ".$sSql);    

        if ($SqlResult_1->NumRows() > 0) {
            $ftt_tst_id                     = $SqlResult_1->fields["ftt_tst_id"];         
        }

    }
    else {
        $sSql = "UPDATE ftt_teste SET 
            ftt_tst_id_prova = '$ftt_tst_id_prova', ftt_tst_id_area = $ftt_tst_id_area
            where ftt_tst_id = $ftt_tst_id";
                
        $dbsis_mysql->Execute($sSql) or die("ERRx001:ALTERA TESTE - \n ".$sSql);  
 
    }
    
    echo "true|$ftt_tst_id";

?>