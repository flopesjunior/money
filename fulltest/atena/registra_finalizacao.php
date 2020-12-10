<?
require_once('../atena.ini.php');

   $ftt_tst_id                   = $_POST["ftt_tst_id"];
   $ftt_tst_carrecao             = $_POST["ftt_tst_carrecao"];
     
    if ($ftt_tst_carrecao == "S"){
        $ftt_tst_status = 3;
    }
    else {
        $ftt_tst_status = 4;
    }

    $sSql = "UPDATE ftt_teste SET ftt_tst_status = $ftt_tst_status, ftt_tst_data_fim = NOW()  WHERE ftt_tst_id = $ftt_tst_id";
    $dbsis_mysql->Execute($sSql) or die("ERRx001:INSERE CONTEUDO - \n ".$sSql);

    //echo "<script>window.location.href = '".$sUrlRaiz."atena/f4.php'</script>";
   
     
    
    
   echo "true";

?>