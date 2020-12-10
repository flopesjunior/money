<?
require_once('../../../indicadores.ini.php');

    $ftt_tsp_id                 = $_POST["ftt_tsp_id"];
    $ftt_tsp_correto            = $_POST["ftt_tsp_correto"];
    $ftt_tst_id                 = $_POST["ftt_tst_id"];
    $ftt_tsp_observacao         = $_POST["ftt_tsp_observacao"];
    
    
    $sSql = "UPDATE ftt_teste_perguntas SET 
        ftt_tsp_corrigido = 'S', ftt_tsp_correto = '$ftt_tsp_correto', ftt_tsp_observacao = '$ftt_tsp_observacao'
        where ftt_tsp_id = $ftt_tsp_id";

    $dbsis_mysql->Execute($sSql) or die("ERRx001:ALTERA TESTE - \n ".$sSql);  
 
    
    $sSql = "
            SELECT ftt_per_tipo, ftt_tsp_corrigido, ftt_tsp_id, ftt_tsp_ordem, ftt_tsp_resp_dissertativa 
            from ftt_teste_perguntas 
            inner join ftt_pergunta on ftt_per_id = ftt_tsp_id_pergunta
            where ftt_tsp_id_teste = $ftt_tst_id and ftt_per_tipo = 1 and ftt_tsp_corrigido = 'N' and ftt_tsp_anulada_tmp_expirado = 0 and ftt_tsp_anulada = 0
            ";   
//                                           echo $sSql."<BR>";

    $SqlResult_2 = $dbsis_mysql->Execute($sSql) or die("ERRx001:serial_Listen <BR>".$sSql);    

    if ($SqlResult_2->NumRows() == 0) {     
        $sSql = "UPDATE ftt_teste SET ftt_tst_carrecao = 'N', ftt_tst_status = 4 WHERE ftt_tst_id = $ftt_tst_id";

        $dbsis_mysql->Execute($sSql) or die("ERRx001:ALTERA TESTE - \n ".$sSql);  
    }       
    
    echo "true";

?>