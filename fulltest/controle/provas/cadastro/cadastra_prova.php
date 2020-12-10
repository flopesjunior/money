<?
require_once('../../../indicadores.ini.php');

    $ftt_prv_id                 = $_POST["ftt_prv_id"];
    $ftt_prv_descricao          = $_POST["ftt_prv_descricao"];
    $ftt_prv_tempo              = $_POST["ftt_prv_tempo"];
    $ftt_prv_nome               = $_POST["ftt_prv_nome"];
    
    
    if (!$ftt_prv_id){    
        //$sSql = "DELETE FROM apu_apuracao WHERE apu_apu_id_zon = $apu_zon_id AND apu_apu_id_ses = $apu_ses_id";
        //$dbsis_mysql->Execute($sSql) or die("ERRx001:DELETA");    

        
        
        $sSql = "insert into ftt_prova (ftt_prv_nome, ftt_prv_descricao, ftt_prv_tempo, ftt_prv_data_cadastro, ftt_prv_data_ultalt) VALUES 
                ('$ftt_prv_nome', '$ftt_prv_descricao', $ftt_prv_tempo, NOW(), NOW())";

        $dbsis_mysql->Execute($sSql) or die("ERRx001:INSERE PROVA - \n ".$sSql);    

        //Pega o ultimo is inserido
        $sSql = "
                select max(ftt_prv_id) as ftt_prv_id
                from 
                ftt_prova
                ";  
        //                                    echo $sSql."<BR>";

        $SqlResult_1 = $dbsis_mysql->Execute($sSql) or die("ERRx001:serial_Listen - \n ".$sSql);    

        if ($SqlResult_1->NumRows() > 0) {
            $ftt_prv_id                     = $SqlResult_1->fields["ftt_prv_id"];         
        }

    }
    else {
        $sSql = "UPDATE ftt_prova SET 
            ftt_prv_nome = '$ftt_prv_nome',
            ftt_prv_descricao = '$ftt_prv_descricao', 
            ftt_prv_tempo = $ftt_prv_tempo, 
            ftt_prv_data_ultalt = now()
            where ftt_prv_id = $ftt_prv_id";
                
        $dbsis_mysql->Execute($sSql) or die("ERRx001:ALTERA PERGUNTA - \n ".$sSql);  
 
    }
    
    echo "true|$ftt_prv_id";

?>