<?
require_once('../atena.ini.php');

   $ftt_per_id                   = $_POST["ftt_per_id"];
   $ftt_tsp_id                   = $_POST["ftt_tsp_id"];
   $ftt_alt_id                   = $_POST["ftt_alt_id"];
   $ftt_per_tipo                 = $_POST["ftt_per_tipo"];
   $ftt_tsp_resp_dissertativa    = addslashes($_POST["ftt_tsp_resp_dissertativa"]);
   $ftt_tsp_id_teste             = $_POST["ftt_tsp_id_teste"];
   
   if ($ftt_per_tipo == "1"){
       
        $sSql = "UPDATE ftt_teste_perguntas SET 
                 ftt_tsp_respondida = 1, ftt_tsp_resp_dissertativa = '$ftt_tsp_resp_dissertativa', ftt_tsp_anulada = 0  
                 WHERE ftt_tsp_id = $ftt_tsp_id";

        $dbsis_mysql->Execute($sSql) or die("ERRx001:REGISTRA RESPSTA DISSERTSTIVA - \n ".$sSql);  
        
        $sSql = "UPDATE ftt_teste SET 
                 ftt_tst_carrecao = 'S'  
                 WHERE ftt_tst_id = $ftt_tsp_id_teste";

        $dbsis_mysql->Execute($sSql) or die("ERRx001:REGISTRA RESPSTA DISSERTSTIVA - \n ".$sSql);          
               
   }  
   else {  
       
        $sSql = "DELETE FROM ftt_teste_perguntas_alt_selec WHERE ftt_tsa_id_teste_perguntas = $ftt_tsp_id";
        $dbsis_mysql->Execute($sSql) or die("ERRx001:DELETA PERGUNTA RESPONDIDA - \n ".$sSql);                
       
       
        $aAlternativas = explode(";", $ftt_alt_id);

        $sFlag = "S";

        foreach ($aAlternativas as $value) {

             $sSql = "
                         SELECT 
                         ftt_alt_correta
                         FROM ftt_pergunta_alternativas
                         WHERE ftt_alt_id = $value
                 ";  
          //                                           echo $sSql."<BR>";

             $SqlResult_1 = $dbsis_mysql->Execute($sSql) or die("ERRx002:serial_Listen <BR> $sSql");    


             if ($SqlResult_1->NumRows() > 0) {
                  $ftt_alt_correta = $SqlResult_1->fields["ftt_alt_correta"];    
             }     

             if ($ftt_alt_correta == "N"){
                 $sFlag = "N";
             }

//             $sSql = "INSERT INTO ftt_teste_perguntas_alt_selec (ftt_tsa_id_teste_perguntas, ftt_tsa_id_alternativa_selecionada, ftt_tsa_correta) VALUES 
//                      ($ftt_tsp_id, $value, '$ftt_alt_correta')";
             
             $sSql = "INSERT INTO ftt_teste_perguntas_alt_selec (ftt_tsa_id_teste_perguntas, ftt_tsa_id_alternativa_selecionada) VALUES 
                      ($ftt_tsp_id, $value)";             

             $dbsis_mysql->Execute($sSql) or die("ERRx001:REGISTRA ALTERNATIVAS - \n ".$sSql);  
        }
 
//        $sSql = "UPDATE ftt_teste_perguntas SET 
//                 ftt_tsp_respondida = 1, ftt_tsp_correta =  '$sFlag'  
//                 WHERE ftt_tsp_id = $ftt_tsp_id";
        $sSql = "UPDATE ftt_teste_perguntas SET 
                 ftt_tsp_respondida = 1, ftt_tsp_anulada = 0  
                 WHERE ftt_tsp_id = $ftt_tsp_id";
        $dbsis_mysql->Execute($sSql) or die("ERRx001:REGISTRA RESPSTA - \n ".$sSql);  
        
        //Zera tudo
        $sSql = "UPDATE ftt_view_alternativas SET 
                 ftt_vwa_selecionada = null  
                 WHERE ftt_vwa_id_pergunta = $ftt_per_id";
        $dbsis_mysql->Execute($sSql) or die("ERRx001:REGISTRA RESPSTA - \n ".$sSql);  
        
        
        foreach ($aAlternativas as $value) {
            //marca como selecionada
            $sSql = "UPDATE ftt_view_alternativas SET 
                     ftt_vwa_selecionada = 1  
                     WHERE ftt_vwa_id_alterativa = $value and ftt_vwa_id_teste = $ftt_tsp_id_teste";
            $dbsis_mysql->Execute($sSql) or die("ERRx001:REGISTRA RESPSTA - \n ".$sSql);  
        }        
        
   }
   
     
    
    
   echo "true";

?>