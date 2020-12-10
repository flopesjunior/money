<?
require_once('../atena.ini.php');

     $ftt_per_id                   = $_POST["ftt_per_id"];
     $ftt_tsp_id                   = $_POST["ftt_tsp_id"];
     $ftt_per_tipo                 = $_POST["ftt_per_tipo"];     

    $sSql = "UPDATE ftt_teste_perguntas SET 
            ftt_tsp_anulada = 1,
            ftt_tsp_respondida = 1
            WHERE ftt_tsp_id = $ftt_tsp_id";
                
        $dbsis_mysql->Execute($sSql) or die("ERRx001:REGISTRA RESPSTA - \n ".$sSql);  
        
     if ($ftt_per_tipo == "2" || $ftt_per_tipo == "3"){    
        
        $sSql = "DELETE FROM ftt_teste_perguntas_alt_selec  WHERE ftt_tsa_id_teste_perguntas = $ftt_tsp_id";
        $dbsis_mysql->Execute($sSql) or die("ERRx001:REGISTRA ALTERNATIVAS - \n ".$sSql);      

        //Zera tudo
        $sSql = "UPDATE ftt_view_alternativas SET 
                 ftt_vwa_selecionada = null  
                 WHERE ftt_vwa_id_pergunta = $ftt_per_id";
        $dbsis_mysql->Execute($sSql) or die("ERRx001:REGISTRA RESPSTA - \n ".$sSql);        
     }
     
    echo "true";

?>