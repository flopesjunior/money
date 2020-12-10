<?
require_once('../../../indicadores.ini.php');

    $ftt_per_id = $_POST["ftt_per_id"];

    $sSql = "DELETE FROM ftt_pergunta WHERE ftt_per_id = $ftt_per_id"; 
    $dbsis_mysql->Execute($sSql) or die("ERRx001:DELETA QUESTAO - \n ".$sSql);    
    
    $sSql = "DELETE FROM ftt_pergunta_alternativas WHERE ftt_alt_id_pergunta = $ftt_per_id"; 
    $dbsis_mysql->Execute($sSql) or die("ERRx001:DELETA QUESTAO ITENS - \n ".$sSql);    
    
    echo "true";

?>