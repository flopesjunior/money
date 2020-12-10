<?
require_once('../../../indicadores.ini.php');

    $ftt_tst_id                 = $_POST["ftt_tst_id"];
    
    $sSql = "UPDATE ftt_teste SET ftt_tst_bloqueado = 1, ftt_tst_status = 4 WHERE ftt_tst_id = $ftt_tst_id";
    $dbsis_mysql->Execute($sSql) or die("ERRx001:INSERE CONTEUDO - \n ".$sSql);
 
    echo "true";

?>