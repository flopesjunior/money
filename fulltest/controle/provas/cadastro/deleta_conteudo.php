<?
require_once('../../../indicadores.ini.php');

    $ftt_prc_id = $_POST["ftt_prc_id"];

    $sSql = "DELETE FROM ftt_prova_conteudo WHERE ftt_prc_id = $ftt_prc_id"; 
    $dbsis_mysql->Execute($sSql) or die("ERRx001:DELETA CONTEUDO - \n ".$sSql);    
    
    
    echo "true";

?>