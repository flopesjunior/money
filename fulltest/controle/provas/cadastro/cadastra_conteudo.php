<?
require_once('../../../indicadores.ini.php');

    $ftt_prv_id                 = $_POST["ftt_prv_id"];
    $ftt_prc_id                 = $_POST["ftt_prc_id"];
    $ftt_prc_id_especialidade   = $_POST["ftt_prc_id_especialidade"];
    $ftt_prc_nivel              = $_POST["ftt_prc_nivel"];
    $ftt_prc_quantidade         = $_POST["ftt_prc_quantidade"];

    
    
    if (!$ftt_prc_id){    
        //$sSql = "DELETE FROM apu_apuracao WHERE apu_apu_id_zon = $apu_zon_id AND apu_apu_id_ses = $apu_ses_id";
        //$dbsis_mysql->Execute($sSql) or die("ERRx001:DELETA");    

        $sSql = "
            select *
            from ftt_prova_conteudo
            where 
            ftt_prc_id_especialidade = $ftt_prc_id_especialidade AND
            ftt_prc_nivel = $ftt_prc_nivel AND 
            ftt_prc_id_prova = $ftt_prv_id   
            ";  
    //                                    echo $sSql."<BR>";

        $SqlResult_1 = $dbsis_mysql->Execute($sSql) or die("ERRx001:serial_Listen");    


        if ($SqlResult_1->NumRows() > 0) {    
            echo "existe";
            exit;
        }    

        $sSql = "INSERT INTO ftt_prova_conteudo (
        ftt_prc_id_especialidade, 
        ftt_prc_nivel, 
        ftt_prc_quantidade, 
	ftt_prc_id_prova
	) VALUES (
        $ftt_prc_id_especialidade, 
        $ftt_prc_nivel, 
        $ftt_prc_quantidade, 
	$ftt_prv_id
	)";        
        
        $dbsis_mysql->Execute($sSql) or die("ERRx001:INSERE CONTEUDO - \n ".$sSql);    

    }
    else {
        $sSql = "UPDATE ftt_prova_conteudo SET 
            ftt_prc_id_especialidade = $ftt_prc_id_especialidade, 
            ftt_prc_nivel = $ftt_prc_nivel, 
            ftt_prc_quantidade = $ftt_prc_quantidade,
            ftt_prc_id_prova = $ftt_prv_id    
            WHERE ftt_prc_id = $ftt_prc_id";
                
        $dbsis_mysql->Execute($sSql) or die("ERRx001:ALTERA CONTREUDO - \n ".$sSql);  
 
    }
    
    echo "true";

?>