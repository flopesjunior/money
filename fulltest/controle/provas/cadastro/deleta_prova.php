<?
require_once('../../../indicadores.ini.php');

    $ftt_prv_id = $_POST["ftt_prv_id"];

    $sSql = "DELETE FROM ftt_prova WHERE ftt_prv_id = $ftt_prv_id"; 
    $dbsis_mysql->Execute($sSql) or die("ERRx001:DELETA PROVA - \n ".$sSql);    
    
    $sSql = "DELETE FROM ftt_prova_conteudo WHERE ftt_prc_id_prova = $ftt_prv_id"; 
    $dbsis_mysql->Execute($sSql) or die("ERRx001:DELETA CONTEUDO - \n ".$sSql);    

    echo "true";

?>