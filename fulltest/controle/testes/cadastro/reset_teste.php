<?
require_once('../../../indicadores.ini.php');

    $ftt_tst_id                 = $_POST["ftt_tst_id"];
    
    
    $sSql = "delete from ftt_teste_perguntas_alt_selec where ftt_tsa_id_teste_perguntas in (select ftt_tsp_id from ftt_teste_perguntas where ftt_tsp_id_teste = $ftt_tst_id)";
    $dbsis_mysql->Execute($sSql) or die("ERRx001:DELETE ftt_teste_perguntas_alt_selec - \n ".$sSql);    
    
    
    $sSql = "delete from ftt_teste_perguntas where ftt_tsp_id_teste = $ftt_tst_id";
    $dbsis_mysql->Execute($sSql) or die("ERRx001:DELETE ftt_teste_perguntas - \n ".$sSql);    
 
    $sSql = "update ftt_teste set ftt_tst_status = 1, ftt_tst_data_inicio = null, ftt_tst_data_fim = null, ftt_tst_bloqueado = 0, ftt_tst_tempo_excedido = 0 where ftt_tst_id = $ftt_tst_id";
    $dbsis_mysql->Execute($sSql) or die("ERRx001:UPDATE ftt_teste - \n ".$sSql);
    
    echo "true";

?>